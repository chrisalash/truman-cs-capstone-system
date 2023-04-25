import type { Actions, ServerLoad } from '@sveltejs/kit';
import { prisma } from '$lib/server/prisma';
import { fail } from '@sveltejs/kit';

export const load: ServerLoad = async () => {
  try {
    //console.log(await prisma.$queryRaw`SELECT * FROM capstone_presentations;`)
    return {
      slot_taken:
        await prisma.$queryRaw`SELECT IF(capstone_presentations.username="",1,0) slot_taken,time_start, time_end FROM capstone_presentations;`
    };
  } catch (error) {
    console.error(error);
  }
};
export const actions: Actions = {
  Student_Change_Time: async ({ request }) => {
    const { username, presentation_id } = Object.fromEntries(await request.formData()) as {
      username: string;
      presentation_id: string;
    };

    try {
      await prisma.$queryRaw`Update capstone_presentations set username = 
            ${username} where id = ${presentation_id}`;
    } catch (err) {
      console.error(err);
      return fail(500, { message: 'Could not update the presenter' });
    }

    return {
      status: 201
    };
  },

  Admin_Save_Time: async ({ request }) => {
    const { date, start_time, end_time } = Object.fromEntries(await request.formData()) as {
      date: string;
      start_time: string;
      end_time: string;
    };
    const start_date = new Date(date + ' ' + start_time + ':00');
    const end_date = new Date(date + ' ' + end_time + ':00');
    try {
      await prisma.$queryRaw`Insert Into capstone_presentations (username, time_start, time_end) Values ("",${start_date}, ${end_date})`;
    } catch (err) {
      console.error(err);
      return fail(500, { message: 'Could insert time' });
    }

    return {
      status: 201
    };
  }
};
