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
        GROUP_CONCAT(DATE_FORMAT(cp.time_end, '%h:%i %p') ORDER BY cp.time_start SEPARATOR ',') AS time_end
        FROM capstone_presentations AS cp
        GROUP BY date
        ORDER BY date ASC;
      `)
    let lengths: number[] = [];
    for (let count = 0; count < prez.length; count++) {
      prez[count].slot_taken = prez[count].slot_taken.split(',');
      prez[count].id = prez[count].id.split(',');
      prez[count].time_start = prez[count].time_start.split(',');
      prez[count].time_end = prez[count].time_end.split(',');
      prez[count].username = prez[count].username.split(',');
      console.log(prez[count].username);
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
  student_change_time: async ({ request }) => {
    const { username, presentation_id } = Object.fromEntries(await request.formData()) as {
      username: string;
      presentation_id: string;
    };

    try {
      console.log(username);
      console.log(presentation_id);
      if (
        await prisma.$queryRaw(
          Prisma.sql`SELECT username FROM capstone_presentations WHERE username Like ${username}`
        )
      ) {
        await prisma.$queryRaw(
          Prisma.sql`Update capstone_presentations set username = "" where username = ${username}`
        );
      }
      await prisma.$queryRaw(
        Prisma.sql`Update capstone_presentations set username = ${username} where id = ${presentation_id}`
      );
    } catch (err) {
      console.error(err);
      return fail(500, { message: 'Could not update the presenter' });
    }

    return {
      status: 201
    };
  },

  Remove_Self: async ({ request }) => {
    const { username, presentation_id } = Object.fromEntries(await request.formData()) as {
      username: string;
      presentation_id: string;
    };

    try {
      console.log(username);
      console.log(presentation_id);
      if (
        await prisma.$queryRaw(
          Prisma.sql`SELECT username FROM capstone_presentations WHERE username Like ${username}`
        )
      ) {
        await prisma.$queryRaw(
          Prisma.sql`Update capstone_presentations set username = "" where id = ${presentation_id}`
        );
      }
      await prisma.$queryRaw(
        Prisma.sql`Update capstone_presentations set username = "" where id = ${presentation_id}`
      );
    } catch (err) {
      console.error(err);
      return fail(500, { message: 'Could not remove the presenter' });
    }

    return {
      status: 201
    };
  }
};
