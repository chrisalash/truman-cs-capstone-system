<script lang='ts'>
  import { fromJSON } from "postcss";
  import type { PageData } from './$types'
  import Popup from '../../components/popup.svelte';
  
  export let data : PageData
  $:({ presentations }= data)
  $:({ table_size }= data)

  $: notNull = table_size as number


  let tableContainer: HTMLDivElement;
  let startY = 0;
  let startHeight = 0;
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();
  let rows = [];
  let username = "testuserna"

</script>

<main class='flex flex-col'>
  <!-- Title container -->
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Student Tools</h1>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-3xl text-violet-800'>Description</h1>
    <p class='text-xl'>Select one designated time for you to present your capstone presentation.</p>
  </div>
  <!-- Presentations container -->
  <div class='flex flex-col ml-4 w-full bg-white rounded p-4'>
    <h1 class='text-3xl mb-4 text-violet-800'>Designated Time</h1>
    <div class='mb-4'>
      <h3 class='text-3xl'>Spring - {year}</h3>
    </div>
    <!-- Table to display presentation data -->
    <div bind:this={tableContainer} class='overflow-x-auto'>
      <table class='border-collapse w-full'>
        <thead>
          <tr>
            <!-- Loop through presentations and display the date as table header -->
            {#each presentations as presentation}
              <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>{presentation.date}</th>
            {/each}
          </tr>
        </thead>
        <tbody>
          <!-- Loop through the presentations and display the start and end times -->
          {#each {length: notNull} as count, i}
            <tr>
              {#each presentations as presentation}
                {#if presentation.time_start[i] != undefined}
                  {#if presentation.slot_taken[i] == 1}
                  <!-- Display a button to add the user if the slot does not have a user assigned to it -->
                    <td style='height: 74px; min-width: 600px' class='border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-gray-400 text-center text-xl m-10 relative'>
                      <form action="?/Student_Change_Time" method="POST">
                        <button class='w-full h-full absolute top-0 left-0'>
                          {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                        </button>
                        <input type="hidden" name="presentation_id" value={presentation.id[i]} />
                        <input type="hidden" name="username" value={username} />
                      </form>
                    </td>
                  {:else if presentation.username[i] == username}
                  <!-- Display a button to remove the user if a slot has their username -->
                    <td style='height: 74px; min-width: 600px' class='border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer font-bold text-center text-xl m-10 relative'>
                      <form action="?/Remove_Self" method="POST">
                        <button class='w-full h-full absolute top-0 left-0'>
                          {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                        </button>
                        <input type="hidden" name="presentation_id" value={presentation.id[i]} />
                        <input type="hidden" name="username" value={username} />
                      </form>
                    </td>
                  {:else}
                  <!-- Display the start and end times if the slot is taken -->
                    <td style='height: 74px; min-width: 600px' class='border-solid border-2 border-gray-200 p-2 text-center text-xl m-10'>
                      {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                    </td>
                  {/if}
                {:else}
                  <td></td>
                {/if}
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </div>
</main>
