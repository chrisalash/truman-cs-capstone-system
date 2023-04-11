<script lang='ts'>
  // Import the required modules and types
  import { fromJSON } from "postcss";
  import type { PageData } from './$types'

  // Declare reactive variables and bind them to the incoming data
  export let data : PageData
  $:({ presentations }= data)
  $:({ table_size }= data)

  // Ensure the table_size is not null
  $: notNull = table_size as number

   // Declare and initialize other variables
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
    <h1 class='text-5xl text-violet-800'>Professor Tools</h1>
  </div>
  <!-- Presentations container -->
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <div class='mb-4'>
      <h3 class='text-3xl'>Spring - {year}</h3>
    </div>
    <!-- Table to display presentation data -->
    <div bind:this={tableContainer}>
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
                  {#if presentation.slot_taken[i] == 0}
                    <!-- Display a button to remove a student if the slot is taken -->
                    <td style='height: 100%' class='border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-center text-xl m-10'>
                      <form action="?/Remove_Student" method="POST">
                        <button style="width: 100%; height: 100%">
                          {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                          <span class='text-gray-600'>{presentation.username[i]}</span>
                        </button>
                        <input type="hidden" name="presentation_id" value={presentation.id[i]} />
                        <input type="hidden" name="username" value={username} />
                      </form>
                    </td>
                  {:else}
                    <!-- Display the start and end times if the slot is not taken -->
                    <td class='border-solid border-2 border-gray-200 p-2 text-center text-gray-500 text-xl m-10'>
                      {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                      <span class='text-gray-400'>No Student</span>
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
  <!-- Additional container for other content -->
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>Another cell if need be.</div>
</main>