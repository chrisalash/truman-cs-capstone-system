import type { Actions, ServerLoad } from "@sveltejs/kit";
import { prisma } from "$lib/server/prisma"
import { fail } from "@sveltejs/kit";

export const load: ServerLoad = async () => {
    return {
        times: await prisma.spring2023.findMany()
    }
}

export const actions: Actions = {
    
};