<script lang="ts">
  import { username } from '$lib/stores';
  import { onMount } from 'svelte';

  onMount(() => {
    const cookies = document.cookie.split('; ');
      for (const cookie of cookies) {
        console.log(cookie)
        const [name, value] = cookie.split('=');
        if (name === 'username') {
          username.set(value);
        }
    }
  }
);
</script>

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Computer Science Capstone Presentation Tools</h1>
  </div>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    Put some description here.
  </div>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    Another cell if need be.
  </div>
</main>
