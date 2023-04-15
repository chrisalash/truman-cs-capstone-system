import type { Actions, ServerLoad } from "@sveltejs/kit";
import { prisma } from "$lib/server/prisma";
import { Prisma } from '@prisma/client'
import { fail } from "@sveltejs/kit";

export const actions: Actions = { 

    Set_Dates: async ({ request }) => {
        const { date, time_start, time_end } = Object.fromEntries(await request.formData()) as { 
            date: string, 
            time_start: string,
            time_end: string
        }

        let dates: String[] = date.split(',')
        let times_start: String[] = time_start.split(',')
        let times_end: String[] = time_end.split(',')
        try{
            for(let count = 0; count < dates.length; count++){
                let start_date = dates[count]+ " " + times_start[count]
                let end_date = dates[count] + " " + times_end[count]
                console.log(start_date)
                console.log(end_date)
                console.log(date)
                console.log(time_start)
                console.log(time_end)
                await prisma.$queryRaw(Prisma.sql`INSERT INTO capstone_presentations(time_start, time_end) values(${start_date},${end_date})`)
            }
        } catch(err) {
            console.error(err)
            return fail(500, { message: 'Could not remove the presenter'})
        }
    }
}