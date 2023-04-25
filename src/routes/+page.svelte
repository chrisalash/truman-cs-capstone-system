<script lang="ts">
  import { username } from '$lib/stores';
  import { onMount } from 'svelte';

  onMount(() => {
    username.set("jlh4264");

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
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-3xl text-violet-800 mb-2'>About</h1>
    <p class='text-xl'>This website is to simplify the capstone presentation process for students and professors by offering a centralized platform with a user-friendly interface and a comprehensive database, eliminating the need for third-party websites and streamlining scheduling and management.</p>
  </div>
  <div class='flex flex-col ml-4 w-full bg-white rounded p-4'>
    <h1 class='text-3xl text-violet-800 mb-2'>Key Features</h1>
    <ul class='text-xl ml-8 list-disc'>
      <li>Easy selection of presentation dates and times for students.</li>
      <li>Clear and concise schedule view for professors.</li>
      <li>Single, centralized database for both students and professors</li>
      <li>No need for third-party websites or software.</li>
      <li>Efficient and streamlined capstone presentation management.</li>
    </ul>
  </div>
</main>
