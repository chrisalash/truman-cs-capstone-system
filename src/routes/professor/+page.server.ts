import type { Actions, ServerLoad } from '@sveltejs/kit';
import { prisma } from '$lib/server/prisma';
import { Prisma } from '@prisma/client';
import { fail } from '@sveltejs/kit';

// Server-side load function to fetch presentation data from the database
export const load: ServerLoad = async () => {
  try {
    let prez = await prisma.$queryRaw(Prisma.sql`SELECT
        GROUP_CONCAT(IF(cp.username="",1,0) ORDER BY cp.time_start SEPARATOR ',') AS slot_taken,
        GROUP_CONCAT(cp.id ORDER BY cp.time_start SEPARATOR ',') AS id,
        GROUP_CONCAT(cp.username ORDER BY cp.time_start SEPARATOR ',') AS username,
        DATE_FORMAT(cp.time_start, '%m/%d/%Y') AS date,
        GROUP_CONCAT(DATE_FORMAT(cp.time_start, '%h:%i %p') ORDER BY cp.time_start SEPARATOR ',') AS time_start,
        GROUP_CONCAT(DATE_FORMAT(cp.time_end, '%h:%i %p') ORDER BY cp.time_start SEPARATOR ',') AS time_end,
        GROUP_CONCAT(cp.professors ORDER BY cp.time_start SEPARATOR ';') AS professors
        FROM capstone_presentations AS cp
        GROUP BY date
        ORDER BY date ASC;
      `);
    let lengths: number[] = [];
    for (let count = 0; count < prez.length; count++) {
      prez[count].slot_taken = prez[count].slot_taken.split(',');
      prez[count].id = prez[count].id.split(',');
      prez[count].time_start = prez[count].time_start.split(',');
      prez[count].time_end = prez[count].time_end.split(',');
      prez[count].username = prez[count].username.split(',');
      prez[count].professors = prez[count].professors.split(';');
      for (let count2 = 0; count2 < prez[count].professors.length; count2++) {
        prez[count].professors[count2] = prez[count].professors[count2].split(',');
      }
      console.log(prez[count].professors);
      lengths.push(prez[count].time_start.length);
    }
    return {
      presentations: prez,
      table_size: Math.max(...lengths)
    };
  } catch (error) {
    console.error(error);
  }
};

// Actions that the webpage will perform that access the database
export const actions: Actions = {
  Remove_Student: async ({ request }) => {
    const { username, presentation_id } = Object.fromEntries(await request.formData()) as {
      username: string;
      presentation_id: string;
    };

        try{
            console.log(username);
            console.log(presentation_id);
            if(await prisma.$queryRaw(Prisma.sql`SELECT username FROM capstone_presentations WHERE username Like ${username}`)){
                await prisma.$queryRaw(Prisma.sql`Update capstone_presentations set username = "" where id = ${presentation_id}`)
            }
            
        } catch(err) {
            console.error(err)
            return fail(500, { message: 'Could not remove the presenter'})
        }

        return {
            status: 201
        }
    },

    Professor_Signup: async ({ request }) => {
      const { username, professors, presentation_id } = Object.fromEntries(await request.formData()) as {
        username: string;
        professors: string;
        presentation_id: string;
      };
  
          try{
              console.log(username);
              console.log(presentation_id);
              let profarr = professors.split(",")
              const index = profarr.indexOf(username, 0);
              if(index > -1){
                  profarr.splice(index, 1);
              }
              else {
                profarr.push(username);
              }
              await prisma.$queryRaw(Prisma.sql`Update capstone_presentations set professors = ${profarr.toString} where id = ${presentation_id}`);
              
          } catch(err) {
              console.error(err)
              return fail(500, { message: 'Could not remove the presenter'})
          }
  
          return {
              status: 201
          }
  }
};
