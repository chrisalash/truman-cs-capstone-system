<script lang='ts'>
  import '../app.css';

  let links = [
    { name: 'Home', href: './' },
    { name: 'Student', href: '/student' },
    { name: 'Professor', href: '/professor' },
    { name: 'Department Chair', href: '/department-chair' }
  ];
</script>

<nav class='transition-all duration-200 transitionoverflow-y-auto bg-white w-56 h-screen flex justify-center fixed top-0 -left-full lg:left-0'>
  <ul class='w-full'>
    <div class='h-32 m-3 mt-6 flex justify-center align-center'>
      <img src='/logo.jpg' alt='logo'>
    </div>
    <p class='flex justify-center align-center text-3xl text-violet-800'>Capstone</p>
    <p class='flex justify-center align-center text-3xl text-violet-800'>Presentations</p>
    <div class='h-0.5 m-5 mt-6 mb-2 flex justify-center align-center bg-gray-200'></div>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='#'>Capstone System</a>
    </li>
    <div class='h-0.5 m-5 mt-2 mb-2 flex justify-center align-center bg-gray-200'></div>
    {#each links as link}
      <li class='flex justify-center'>
        <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href={link.href}>{link.name}</a>
      </li>
    {/each}
    <div class='h-0.5 m-5 mt-2 mb-2 flex justify-center align-center bg-gray-200'></div>
    <li class='flex justify-center'>
      <a class='transition-all duration-200 w-72 m-4 mt-1 mb-2 p-3 flex justify-start align-center rounded-lg hover:bg-gray-200' href='/admin'>Admin</a>
    </li>
  </ul>
</nav>

<slot/>
