<script lang='ts'>
  import { username } from '$lib/stores';
  import '../app.css';

  let usernameValue: string;

  username.subscribe(value => {
		usernameValue = value;
	});
</script>

<nav class='transition-all duration-200 transitionoverflow-y-auto bg-white w-56 h-screen flex justify-center fixed top-0 -left-full lg:left-0'>
  <ul class='w-full'>
    <div class='h-32 m-3 mt-6 flex justify-center align-center'>
      <img src='/logo.jpg' alt='logo'>
    </div>
    <p class='flex justify-center align-center text-3xl text-violet-800'>Capstone</p>
    <p class='flex justify-center align-center text-3xl text-violet-800'>Presentations</p>
    <div class='h-0.5 m-5 mt-6 mb-2 flex justify-center align-center bg-gray-200'></div>
    <li class='flex flex-col justify-center'>
      <h1 class='w-72 ml-7 mt-2 text-xl flex justify-start align-center rounded-lg'>Username:</h1>
      <h1 class='w-72 ml-7 flex justify-start align-center rounded-lg'>{usernameValue}</h1>
    </li>
    <div class='h-0.5 m-5 mt-6 mb-2 flex justify-center align-center bg-gray-200'></div>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='#'>Capstone System</a>
    </li>
    <div class='h-0.5 m-5 mt-2 mb-2 flex justify-center align-center bg-gray-200'></div>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/#'>Home</a>
    </li>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/student'>Student</a>
    </li>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/professor'>Professor</a>
    </li>
    {#if usernameValue == "jlh4264" || usernameValue == "cah1357"}
      <li class='flex justify-center'>
        <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/department-chair'>Department Chair</a>
      </li>
    {/if}
    {#if usernameValue == "jlh4264"}
      <div class='h-0.5 m-5 mt-2 mb-2 flex justify-center align-center bg-gray-200'></div>
      <li class='flex justify-center'>
        <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/admin'>Admin</a>
      </li>
    {/if}
  </ul>
</nav>
