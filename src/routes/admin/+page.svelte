<script lang='ts'>
import { goto } from '$app/navigation';

  const databases = ["none","student", "capstone_presentations"]

  function route_to_database(event: Event) {
    let selectedRoute = (event.target as HTMLSelectElement).value.trim();
    let newRoute = `admin/${selectedRoute}`;
    if(selectedRoute == "none") {
      newRoute = `admin/`
    }
    goto(newRoute);
  }

</script>

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Admin Tools</h1>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>Warning</h1>
    This is the administrative access point. If you are not an authorized administrator, please leave now.
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>Database Access</h1>
    <div class="mt-4 flex items-center space-x-2">
      <label for="select" class="text-gray-700 font-medium">Select an option:</label>
    <select on:change={route_to_database} class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue w-56">
      {#each databases as databas}
      <option>
        {databas}
      </option>
      {/each}
    </select>
    </div>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>View Logs</h1>
    Some text.
  </div>
</main>
