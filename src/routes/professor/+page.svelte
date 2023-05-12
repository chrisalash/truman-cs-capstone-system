<script lang="ts">
  // Import the required modules and types
  import { fromJSON } from 'postcss';
  import type { PageData } from './$types';
  import { username } from '$lib/stores';
  import { onMount } from 'svelte';


  // Declare reactive variables and bind them to the incoming data
  export let data: PageData;
  $: ({ presentations } = data);
  $: ({ table_size } = data);
  $: ({ prof_signup } = data);

  // Ensure the table_size is not null
  $: notNull = table_size as number;

  // Declare and initialize other variables
  let tableContainer: HTMLDivElement;
  let startY = 0;
  let startHeight = 0;
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();
  let rows = [];

  let usernameValue: string;

  onMount(() => {
    const cookies = document.cookie.split('; ');
    for (const cookie of cookies) {
      console.log(cookie);
      const [name, value] = cookie.split('=');
      if (name === 'username') {
        username.set(value);
      }
    }
  });

  username.subscribe((value) => {
    usernameValue = value;
  });
  

</script>

<main class="flex flex-col">
  <!-- Title container -->
  <div class="flex ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-5xl text-violet-800">Professor Tools</h1>
  </div>
  <div class="flex flex-col ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-3xl text-violet-800">Description</h1>
    <p class="text-xl">View all student capstone presentation times and sign up for days to attend presentations.</p>
  </div>
  <!-- Professor Signup container -->
  <div class="flex flex-col ml-4 w-full bg-white rounded p-4">
    <h1 class="text-3xl mb-4 text-violet-800">Professor Signup</h1>
      
    <!-- Table to display professor signup data -->
    <div bind:this={tableContainer} class="overflow-x-auto">
        <table class="border-collapse w-full">
          <thead>
            <tr>
              <!-- Loop through presentations and display the date as table header -->
              {#each presentations as presentation}
                <th
                  style="min-width: 600px"
                  class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300"
                  >{presentation.date}</th
                >
              {/each}
            </tr>
            <!-- Row for the professors -->
            <tr>
              {#each presentations as presentation}
                {#if prof_signup.some(profs => profs.date_of_presentation === presentation.date)}
                  {#each prof_signup as profs}
                    {#if profs.date_of_presentation === presentation.date}
                      <td
                        style="height: 74px; min-width: 600px"
                        class="border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-gray-600 text-center text-xl m-10 relative"
                      >
                        <form action="?/Professor_Signup" method="POST">
                          <button class="w-full h-full absolute top-0 left-0">
                            {profs.professors}<br />
                          </button>
                          <input type="hidden" name="date" value={profs.date_of_presentation} />
                          <input type="hidden" name="username" value={usernameValue} />
                        </form>
                      </td>
                    {/if}
                  {/each}
                {:else}
                  <td
                    style="height: 74px; min-width: 600px"
                    class="border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-gray-600 text-center text-xl m-10 relative"
                  >
                    <form action="?/Professor_Signup" method="POST">
                      <button class="w-full h-full absolute top-0 left-0">
                        Empty<br />
                      </button>
                      <input type="hidden" name="date" value={presentation.date} />
                      <input type="hidden" name="username" value={usernameValue} />
                    </form>
                  </td>
                {/if}
              {/each}
            </tr>
          </thead>
        </table>
    </div>
  </div>
  
  <!-- Presentations container -->
  <div class="flex flex-col ml-4 w-full bg-white rounded p-4">
    <h1 class="text-3xl mb-4 text-violet-800">Student Times</h1>
    <!-- Table to display presentation data -->
    <div bind:this={tableContainer} class="overflow-x-auto">
      <table class="border-collapse w-full">
        <thead>
          <tr>
            <!-- Loop through presentations and display the date as table header -->
            {#each presentations as presentation}
              <th
                class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300"
                >{presentation.date}</th
              >
            {/each}
          </tr>
          <!-- Row for the professors -->
          
        </thead>
        <tbody>
          <!-- Loop through the presentations and display the start and end times -->
          {#each { length: notNull } as count, i}
            <tr>
              {#each presentations as presentation}
                {#if presentation.time_start[i] != undefined}
                  {#if presentation.slot_taken[i] == 0}
                    <!-- Display start and end times and the name of student signed up for the slot -->
                    <td
                      style="height: 100%; min-width: 600px"
                      class="border-solid border-2 border-gray-200 p-2 text-center text-gray-600 text-xl m-10"
                    >
                      {presentation.time_start[i]}-{presentation.time_end[i]}<br />
                      {presentation.username[i]}
                    </td>
                  {:else}
                    <!-- Display the start and end times if the slot is not taken -->
                    <td
                      style="min-width: 600px"
                      class="border-solid border-2 border-gray-200 p-2 text-center text-gray-400 text-xl m-10"
                    >
                      {presentation.time_start[i]}-{presentation.time_end[i]}<br />
                      <span class="text-gray-400">No Student</span>
                    </td>
                  {/if}
                {:else}
                  <td />
                {/if}
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </div>
</main>
