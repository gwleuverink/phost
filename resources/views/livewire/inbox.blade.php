<main class="flex w-full h-screen">

    <section class="flex flex-col pt-3 w-4/12 min-w-72 bg-gray-50 h-full overflow-y-scroll">

      <label class="px-3">
        <input class="rounded-lg p-4 bg-gray-100 transition duration-200 focus:outline-none focus:ring-2 w-full" placeholder="Search...">
      </label>

      <ul class="mt-6">
        <li>
          <x-message-list-item />
        </li>
        <li>
          <x-message-list-item />
        </li>
        <li>
          <x-message-list-item />
        </li>
        <li>
          <x-message-list-item />
        </li>
      </ul>

    </section>

    <section class="w-full px-4 flex flex-col bg-white rounded-r-3xl">

      <div class="flex justify-between items-center h-48 border-b mb-8">

        <div class="flex flex-col">
            <h3 class="font-semibold text-lg">Gedachtegoed</h3>
            <p class="text-light text-gray-400">willem@gedachtegoed.nl</p>
        </div>

        <div>
          <ul class="flex text-gray-400 space-x-4">
            <li class="w-6 h-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
              </svg>
            </li>
            <li class="w-6 h-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </li>

            <li class="w-6 h-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
              </svg>
            </li>
            <li class="w-6 h-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </li>
            <li class="w-6 h-6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
              </svg>
            </li>
          </ul>
        </div>

      </div>

      <section>

        <h1 class="font-bold text-2xl">We need UI/UX designer</h1>

        <article class="mt-8 text-gray-500 leading-7 tracking-wider">
          <p>Hi Willem,</p>

          <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae vel itaque, quas exercitationem officiis repellendus voluptatibus aut quia rerum perspiciatis.</p>
          <p>Beatae perferendis quaerat maxime quod doloremque consequuntur. Incidunt, debitis qui?</p>

          <footer class="mt-12">
            <p>Thanks &amp; Regards,</p>
            <p>Foo Bar</p>
          </footer>
        </article>

      </section>

    </section>
</main>
