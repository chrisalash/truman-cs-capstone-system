import type { Actions, ServerLoad } from "@sveltejs/kit";
import { prisma } from "$lib/server/prisma";
import { Prisma } from '@prisma/client'
import { fail } from "@sveltejs/kit";
import type { RequestHandler } from '@sveltejs/kit';

let database = "capstone_presentations"

async function table_returner (db:string) {
    let table: Object[] = []
    if(db == "student") {
        return await prisma.$queryRaw`SELECT * FROM capstone2.student;`
    }
    else if (db == "capstone_presentations") {
        let hi = await prisma.$queryRaw`SELECT id,username,DATE_FORMAT(time_start,'%Y-%m-%dT%H:%i') as 'time_start',DATE_FORMAT(time_end,'%Y-%m-%dT%H:%i') as 'time_end' FROM capstone_presentations;`
        console.log(isValidDateTimeLocal(hi[0].time_start))
        return await prisma.$queryRaw`SELECT id,username,DATE_FORMAT(time_start,'%Y-%m-%dT%H:%i') as 'time_start',DATE_FORMAT(time_end,'%Y-%m-%dT%H:%i') as 'time_end' FROM capstone_presentations;`
    }
    return table
}

function isValidDateTimeLocal(dateTimeString: string): boolean {
    const regex = /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})$/;
    const match = dateTimeString.match(regex);
    if (!match) {
      return false;
    }
    const year = parseInt(match[1]);
    const month = parseInt(match[2]);
    const day = parseInt(match[3]);
    const hour = parseInt(match[4]);
    const minute = parseInt(match[5]);
    const date = new Date(year, month - 1, day, hour, minute);
    return (
      date.getFullYear() === year &&
      date.getMonth() === month - 1 &&
      date.getDate() === day &&
      date.getHours() === hour &&
      date.getMinutes() === minute
    );
  }
  
  

function get_date(date_string: string) {
    let date = new Date(date_string)

    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add 1 to month since it is zero-indexed
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }

export const load: ServerLoad = async () => {
    try {
        let table: Object[] = await table_returner(database)
        return{ 
            student_info: table,
            columns: await Object.keys(table[0])
        }
    } catch (error) {
        console.error(error)
    }
}
    

export const actions: Actions = { 
    Save_Row: async ({ request }) => {
        const { object } = Object.fromEntries(await request.formData()) as { 
            object: string
        }
        let array=JSON.parse(object)
        console.log(array)
        let key_array = Object.keys(array)

        let keys: string = ""
        let values: string = ""

        keys = key_array[0]
        if(typeof array[key_array[0]] == "string"){
            values ="'" + array[key_array[0]] + "'"
            if (isValidDateTimeLocal(array[key_array[0]])) {
                values ="'" + array[key_array[0]] + "'"
            }
        }
        else {
            values = array[key_array[0]]
        }
        let query: string = 'Update ' + database + ' Set ' + keys + ' = ' + values
        for(let count = 1; count < key_array.length; count++){
            if(typeof array[key_array[count]] == "string"){
                values = "'" + array[key_array[count]] + "'"
                if (isValidDateTimeLocal(array[key_array[count]])) {
                    values ="'" + array[key_array[count]] + "'"
                }
            }
            else {
                values = array[key_array[count]]
            }
            query = query + ', ' + key_array[count] + ' = ' + values
        }
        query = query + " Where id = " + array['id']
        console.log(query)
        try {
            await prisma.$executeRawUnsafe(`${query}`)
        } catch (err) {
            console.error(err)
            return fail(500, { message: 'Could not update the presenter'})
        }

        return {
            status: 201
        }
    },

    Remove_Row: async ({ request }) => {
        const { id } = Object.fromEntries(await request.formData()) as { 
            id: string
        }
        let query = 'Delete from ' + database + ' where id = ' + id
        console.log(query)
        try {
            await prisma.$executeRawUnsafe(`${query}`)
        } catch (err) {
            console.error(err)
            return fail(500, { message: 'Could not update the presenter'})
        }

        return {
            status: 201
        }
    }
}