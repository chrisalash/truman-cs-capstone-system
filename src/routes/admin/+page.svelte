<script lang="ts">
  import { goto } from '$app/navigation';
  import { username } from '$lib/stores';
  import { onMount } from 'svelte';

  const databases = ['none', 'student', 'capstone_presentations', 'capstone_presentations_archive'];

  onMount(() => {
    // TODO: DELETE THIS LATER
    username.set('jlh4264');

    const cookies = document.cookie.split('; ');
    for (const cookie of cookies) {
      console.log(cookie);
      const [name, value] = cookie.split('=');
      if (name === 'username') {
        username.set(value);
      }
    }
  });

  function route_to_database(event: Event) {
    let selectedRoute = (event.target as HTMLSelectElement).value.trim();
    let newRoute = `admin/${selectedRoute}`;
    if (selectedRoute == 'none') {
      newRoute = `admin/`;
    }
    goto(newRoute);
  }
</script>

<main class="flex flex-col">
  <div class="flex ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-5xl text-violet-800">Admin Tools</h1>
  </div>
  <div class="flex flex-col ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-3xl text-violet-800 mb-2">Warning</h1>
    <p class="text-xl">
      This is the administrative access point. If you are not an authorized administrator, please
      leave now.
    </p>
  </div>
  <div class="flex flex-col ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-3xl text-violet-800 mb-2">Database Access</h1>
    <div class="mt-4 flex flex-col items-center space-x-2">
      <h1 class="text-3xl text-violet-800 mb-2">Select an option:</h1>
      <select
        on:change={route_to_database}
        class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue w-56"
      >
        {#each databases as database}
          <option>
            {database}
          </option>
        {/each}
      </select>
    </div>
  </div>
</main>
