import type { Actions, ServerLoad } from "@sveltejs/kit";
import { prisma } from "$lib/server/prisma";
import { Prisma } from '@prisma/client'
import { fail } from "@sveltejs/kit";

export const load: ServerLoad = async () => {
    try {
        let prez = await prisma.$queryRaw(Prisma.sql`SELECT group_concat(IF(capstone_presentations.username="",1,0) separator ',') slot_taken, group_concat((id) separator ',') as id, DATE_FORMAT(time_start, '%m/%d/%Y') as date, group_concat(DATE_FORMAT(time_start, '%h:%i %p') separator ',') as time_start, group_concat(DATE_FORMAT(time_end, '%h:%i %p') separator ',') as time_end FROM capstone_presentations group by date order by date Desc;`)
        let lengths: number[] = []
        for(let count = 0; count < prez.length; count++) {
            prez[count].slot_taken = prez[count].slot_taken.split(',')
            prez[count].id = prez[count].id.split(',')
            prez[count].time_start = prez[count].time_start.split(',')
            prez[count].time_end = prez[count].time_end.split(',')
            lengths.push(prez[count].time_start.length)
        }
        return{
            presentations: prez,
            table_size: Math.max(...lengths)
        }
    } catch (error) {
        console.error(error)
    }
}

export const actions: Actions = { 
    
    Student_Change_Time: async ({ request }) => {
        const { username, presentation_id } = Object.fromEntries(await request.formData()) as { 
            username: string, 
            presentation_id: string
        }

        try{
            if(await prisma.$queryRaw(Prisma.sql`SELECT username FROM capstone_presentations WHERE username Like ${username}`)){
                await prisma.$queryRaw(Prisma.sql`Update capstone_presentations set username = "" where username = ${username}`)
            }
            await prisma.$queryRaw(Prisma.sql`Update capstone_presentations set username = ${username} where id = ${presentation_id}`)
        } catch(err) {
            console.error(err)
            return fail(500, { message: 'Could not update the presenter'})
        }

        return {
            status: 201
        }
    }
}