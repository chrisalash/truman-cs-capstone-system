import type { Actions, ServerLoad } from "@sveltejs/kit";
import { prisma } from "$lib/server/prisma";
import { Prisma } from '@prisma/client'
import { fail } from "@sveltejs/kit";

export const load: ServerLoad = async () => {
    try {
        return{
            presentations: await prisma.$queryRaw(Prisma.sql`SELECT concat(student.first_name, " ", student.last_name) as name, student.banner_id, group_concat((capstone_presentations.id) separator ',') as id, DATE_FORMAT(time_start, '%m/%d/%Y') as date, DATE_FORMAT(time_start, '%h:%i %p') as time_start, DATE_FORMAT(time_end, '%h:%i %p') as time_end FROM capstone_presentations Left Join student ON capstone_presentations.username = student.username group by student.username, time_start, time_end order by date Desc, time_start;`),
        }
    } catch (error) {
        console.error(error)
    }
}