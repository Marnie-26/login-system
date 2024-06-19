<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Regency at Salcedo System</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <script
      src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
      defer
    ></script>
    <script src="{{ asset('assets/js/focus-trap.js') }}"></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <script src="https://kit.fontawesome.com/16f4fda31b.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <div
      class="flex h-screen bg-gray-50 dark:bg-gray-900"
      :class="{ 'overflow-hidden': isSideMenuOpen }"
    >
    @include('partials.sidebar')
        <div class="flex flex-col flex-1 w-full">
            @include('partials.header')
            <main class="h-full pb-16 overflow-y-auto">
                <div class="container grid px-6 mx-auto">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"> Key Monitoring Book </h2>

                {{-- Back button redirection --}}
                @php
                  $backUrl = '';

                  if (request()->has('search_key')) {
                      $backUrl = route('view.key.record');
                  } elseif (request()->has('page')) {
                      $backUrl = route('view.key.record');
                  } else {
                      $backUrl = route('visit.log.key');
                  }
                @endphp

                <div class="mb-6 flex items-center justify-between">
                  <div class="flex space-x-4">
                    <a href="{{ $backUrl }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                      <i class="fa-solid fa-circle-left"></i> Back
                    </a>
                  
                    <a href="{{ route('keys.export.excel') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                      <i class="fa-solid fa-download"></i> Export as Excel
                    </a>
                  </div>
                
                  <form class="flex items-center" action="{{ route('search.key.record') }}" method="GET">
                    <div class="input-group flex items-center">
                      <input type="text" class="block w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Search..." name="search_key" value="{{ $search ?? '' }}">
                      <button type="submit" class="ml-2 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple flex items-center">
                        <i class="fa-solid fa-magnifying-glass ml-2"></i> Search
                      </button>
                    </div>
                  </form>
                </div>
                
                @php
                  // Current page number
                  $currentPage = $keys->currentPage();

                  // Number of records per page
                  $perPage = $keys->perPage();

                  // Total keys
                  $totalKeys = $keys->total();
                @endphp

                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert" id="success-alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeAlert('success-alert')">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.35 14.35a1 1 0 0 1-1.41 0L10 11.41l-2.93 2.94a1 1 0 0 1-1.41-1.41L8.59 10 5.65 7.06a1 1 0 0 1 1.41-1.41L10 8.59l2.94-2.94a1 1 0 0 1 1.41 1.41L11.41 10l2.94 2.94a1 1 0 0 1 0 1.41z"/></svg>
                    </button>
                </div>
                @endif

                @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert" id="error-alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeAlert('error-alert')">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.35 14.35a1 1 0 0 1-1.41 0L10 11.41l-2.93 2.94a1 1 0 0 1-1.41-1.41L8.59 10 5.65 7.06a1 1 0 0 1 1.41-1.41L10 8.59l2.94-2.94a1 1 0 0 1 1.41 1.41L11.41 10l2.94 2.94a1 1 0 0 1 0 1.41z"/></svg>
                    </button>
                </div>
                @endif

                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                          <table class="table table-bordered w-full whitespace-no-wrap" id="keyTable">
                            <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Count</th>
                                <th class="px-4 py-3">Unit No.</th>
                                <th class="px-4 py-3">Authorized by</th>
                                <th class="px-4 py-3">Contractor</th>
                                <th class="px-4 py-3">Purpose</th>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Time Borrowed</th>
                                <th class="px-4 py-3">Time Returned</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @if(!$noResult)
                                    @foreach($keys as $index => $key)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm">{{ $totalKeys - (($currentPage - 1) * $perPage + $index) }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $key->unit_no }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            {{ $key->authorized_by == 'unit_owner' ? 'Unit Owner' : ($key->authorized_by == 'tenant' ? 'Tenant' : $key->authorized_by) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">{{ $key->contractor_name }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $key->borrow_purpose }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $key->borrow_date }}</td>
                                        <td class="px-4 py-3 text-sm">{{ date('h:i A', strtotime($key->time_borrowed)) }}</td>
                                        <td class="px-4 py-3 text-sm">
                                          @if ($key->time_returned)
                                              {{ date('h:i A', strtotime($key->time_returned)) }}
                                          @else
                                              <form id="logTimeOutForm" action="{{ route('log.time.returned') }}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="key_id" value="{{ $key->id }}">
                                                  <input type="time" class="time-out-input block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" name="time_returned">
                                              </form>
                                          @endif
                                          <span class="time-out-cell" style="display: none;">{{ $key->time_returned }}</span>
                                        </td>
                                      
                                        <td class="px-4 py-3">
                                            <div class="flex items-center space-x-4 text-sm">
                                              @if (!$key->time_returned)
                                                <button type="button" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple save-time-out-btn"><i class="fa-solid fa-stopwatch"></i> Log Time Returned</button>
                                              @endif
                                              {{-- Edit Button --}}
                                              <button type="button" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                <i class="fa-solid fa-pencil" @click="openEditKeyModal({{ json_encode($key) }})"></i>
                                              </button>
                                              {{-- Delete button --}}
                                              <button type="button" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                                <i class="fa-solid fa-trash-can" @click="openDeleteKeyModal({{ $key->id }})"></i>
                                              </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-4 py-3 text-sm" colspan="10"><center>No available record.</center></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </div>
                        
                        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                          <span class="flex items-center col-span-3">
                            Showing {{ $keys->firstItem() }} - {{ $keys->lastItem() }} of {{ $keys->total() }}
                          </span>
                          <span class="col-span-2"></span>
                          <!-- Pagination -->
                          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                            <nav aria-label="Table navigation">
                              <ul class="inline-flex items-center">
                                <!-- Previous Page Link -->
                                @if ($keys->onFirstPage())
                                  <li>
                                    <button
                                      class="px-3 py-1 rounded-md rounded-l-lg"
                                      aria-label="Previous"
                                      disabled
                                    >
                                      <svg
                                        aria-hidden="true"
                                        class="w-4 h-4 fill-current"
                                        viewBox="0 0 20 20"
                                      >
                                        <path
                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                          clip-rule="evenodd"
                                          fill-rule="evenodd"
                                        ></path>
                                      </svg>
                                    </button>
                                  </li>
                                @else
                                  <li>
                                    <a
                                      href="{{ $keys->previousPageUrl() }}"
                                      class="px-3 py-1 rounded-md rounded-l-lg"
                                      aria-label="Previous"
                                    >
                                      <svg
                                        aria-hidden="true"
                                        class="w-4 h-4 fill-current"
                                        viewBox="0 0 20 20"
                                      >
                                        <path
                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                          clip-rule="evenodd"
                                          fill-rule="evenodd"
                                        ></path>
                                      </svg>
                                    </a>
                                  </li>
                                @endif

                                <!-- Pagination Elements -->
                                @foreach ($keys->getUrlRange(1, $keys->lastPage()) as $page => $url)
                                  @if ($page == $keys->currentPage())
                                    <li>
                                      <button
                                        class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"
                                      >
                                        {{ $page }}
                                      </button>
                                    </li>
                                  @else
                                    <li>
                                      <a
                                        href="{{ $url }}"
                                        class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                                      >
                                        {{ $page }}
                                      </a>
                                    </li>
                                  @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($keys->hasMorePages())
                                  <li>
                                    <a
                                      href="{{ $keys->nextPageUrl() }}"
                                      class="px-3 py-1 rounded-md rounded-r-lg"
                                      aria-label="Next"
                                    >
                                      <svg
                                        class="w-4 h-4 fill-current"
                                        aria-hidden="true"
                                        viewBox="0 0 20 20"
                                      >
                                        <path
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"
                                          fill-rule="evenodd"
                                        ></path>
                                      </svg>
                                    </a>
                                  </li>
                                @else
                                  <li>
                                    <button
                                      class="px-3 py-1 rounded-md rounded-r-lg"
                                      aria-label="Next"
                                      disabled
                                    >
                                      <svg
                                        class="w-4 h-4 fill-current"
                                        aria-hidden="true"
                                        viewBox="0 0 20 20"
                                      >
                                        <path
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"
                                          fill-rule="evenodd"
                                        ></path>
                                      </svg>
                                    </button>
                                  </li>
                                @endif
                              </ul>
                            </nav>
                          </span>
                        </div>
                    </div>
                </div>
            </main> 
        </div>
    </div>

    <!-- Delete Modal Backdrop -->
    <div
        x-cloak
        x-show="isDeleteKeyModalOpen"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    >
  
    <!-- Delete Modal -->
    <div
      x-cloak
      x-show="isDeleteKeyModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0 transform translate-y-1/2"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 transform translate-y-1/2"
      @keydown.escape="closeDeleteKeyModal"
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog"
      x-bind:id="'deleteKey' + currentKeyId"
    >
      <header class="flex justify-end">
        <button
          class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
          aria-label="close"
          @click="closeDeleteKeyModal"
        >
          <svg
            class="w-4 h-4"
            fill="currentColor"
            viewBox="0 0 20 20"
            role="img"
            aria-hidden="true"
          >
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
              fill-rule="evenodd"
            ></path>
          </svg>
        </button>
      </header>

      <!-- Modal body -->
      <div class="mt-4 mb-6">
        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
          Confirm Delete
        </p>
        <span class="text-gray-700 dark:text-gray-300">Are you sure you want to delete key's record?</span>
      </div>
      <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
        <div class="w-full flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:space-x-6 sm:justify-end">
          <button
            type="button"
            @click="closeDeleteKeyModal"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
          >
            Cancel
          </button>
          <form x-bind:action="'{{ route('delete.key.record', '') }}/' + currentKeyId" method="POST" class="w-full sm:w-auto">
            @csrf
            @method('DELETE')
            <button
              type="submit"
              class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            >
              Delete Record
            </button>
          </form>
        </div>
      </footer>
    </div>
  </div>
  <!-- End of delete modal backdrop -->


  <!-- Edit Modal backdrop -->
  <div
    x-cloak
    x-show="isEditKeyModalOpen"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    
    <!-- Edit Modal -->
    <div
      x-cloak
      x-show="isEditKeyModalOpen"
      x-transition:enter="transition ease-out duration-150"
      x-transition:enter-start="opacity-0 transform translate-y-1/2"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0 transform translate-y-1/2"
      @keydown.escape="closeEditKeyModal"
      class="w-full max-h-full overflow-y-scroll px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog"
      id="editKey"
    >
    <header class="flex justify-end">
      <button
        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover:text-gray-700"
        aria-label="close"
        @click="closeEditKeyModal"
      >
        <svg
          class="w-4 h-4"
          fill="currentColor"
          viewBox="0 0 20 20"
          role="img"
          aria-hidden="true"
        >
          <path
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"
            fill-rule="evenodd"
          ></path>
        </svg>
      </button>
    </header>

    <!-- Modal body -->
    <div class="mt-4 mb-6">
      <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
        Edit Key's Record
      </p>
      <form action="{{ route('update.key.record') }}" method="post">
        @csrf
        @method('POST')
        <input type="hidden" name="key_id" x-model="editingKey.id" />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-6">
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Unit No.</label>
              <input
                type="text"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="unit_no"
                x-model="editingKey.unit_no"
                required
              />
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Authorized by</label>
              <label>
                <select
                  name="authorized_by"
                  x-model="editingKey.authorized_by"
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required
                  >
                    <option value="" disabled selected class="text-gray-500">--Select--</option>
                    <option value="unit_owner">Unit Owner</option>
                    <option value="tenant">Tenant</option>
                </select>
            </label>
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Contractor Name</label>
              <input
                type="text"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="contractor_name"
                x-model="editingKey.contractor_name"
                required
              />
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Purpose</label>
              <input
                type="text"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="borrow_purpose"
                x-model="editingKey.borrow_purpose"
                required
              />
            </div>
          </div>
          <div class="space-y-6">
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Date</label>
              <input
                type="date"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="borrow_date"
                x-model="editingKey.borrow_date"
                required
              />
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Time Borrowed</label>
              <input
                type="time"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="time_borrowed"
                x-model="editingKey.time_borrowed"
                required
              />
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 dark:text-gray-400">Time Returned</label>
              <input
                type="time"
                class="block w-full mt-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                name="time_returned"
                x-model="editingKey.time_returned"
              />
            </div>
          </div>
        </div>
        
        <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
          <button
            type="button"
            @click="closeEditKeyModal"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          >
            Update
          </button>
        </footer>
      </form>
    </div>
  </div>
  <!-- End of edit modal backdrop -->

  <style>
    /* Fixed the blinking issue on every page visit */
    [x-cloak] {
        display: none !important;
    }
  </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
       // Close button on alert
       function closeAlert(alertId) {
            var alert = document.getElementById(alertId);
            if (alert) {
                alert.style.display = 'none';
            }
        }
        
        // Hide alerts after a short duration
        window.onload = function() {
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                if (successAlert) {
                    successAlert.style.display = 'none';
                }

                var errorAlert = document.getElementById('error-alert');
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
            }, 3000);
        };

      // Logging time out
      document.addEventListener('DOMContentLoaded', function() {
        const saveTimeOutButtons = document.querySelectorAll('.save-time-out-btn');
        
        saveTimeOutButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const row = button.closest('tr');
                const keyId = row.querySelector('input[name="key_id"]').value;
                const timeOutInput = row.querySelector('.time-out-input');
                const timeOutValue = timeOutInput.value;
                
                // Format the time to AM/PM format
                const formattedTimeOutValue = timeOutValue ? moment(timeOutValue, 'HH:mm').format('h:mm A') : '';
                const formData = new FormData();
                formData.append('key_id', keyId);
                formData.append('time_returned', timeOutValue);

                fetch('{{ route('log.time.returned') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                      const successAlert = document.createElement('div');
                      successAlert.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700', 'px-4', 'py-3', 'rounded-lg', 'relative', 'mb-6');
                      successAlert.setAttribute('role', 'alert');
                      successAlert.id = 'success-alert';

                      const strong = document.createElement('strong');
                      strong.classList.add('font-bold');
                      strong.textContent = 'Success!';
                      successAlert.appendChild(strong);

                      const span = document.createElement('span');
                      span.classList.add('block', 'sm:inline');
                      span.textContent = data.message;
                      successAlert.appendChild(span);

                      const button = document.createElement('button');
                      button.classList.add('absolute', 'top-0', 'bottom-0', 'right-0', 'px-4', 'py-3');
                      button.setAttribute('onclick', "closeAlert('success-alert')");

                      const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                      svg.classList.add('fill-current', 'h-6', 'w-6', 'text-green-500');
                      svg.setAttribute('role', 'button');
                      svg.setAttribute('viewBox', '0 0 20 20');

                      const title = document.createElementNS("http://www.w3.org/2000/svg", "title");
                      title.textContent = 'Close';
                      svg.appendChild(title);

                      const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                      path.setAttribute('d', 'M14.35 14.35a1 1 0 0 1-1.41 0L10 11.41l-2.93 2.94a1 1 0 0 1-1.41-1.41L8.59 10 5.65 7.06a1 1 0 0 1 1.41-1.41L10 8.59l2.94-2.94a1 1 0 0 1 1.41 1.41L11.41 10l2.94 2.94a1 1 0 0 1 0 1.41z');
                      svg.appendChild(path);

                      button.appendChild(svg);
                      successAlert.appendChild(button);

                      const tableContainer = document.querySelector('.w-full.overflow-hidden.rounded-lg.shadow-xs');
                      tableContainer.parentNode.insertBefore(successAlert, tableContainer);
                        
                      const timeOutCell = row.querySelector('.time-out-cell');
                      timeOutCell.textContent = formattedTimeOutValue;

                      timeOutInput.style.display = 'none';
                      timeOutCell.style.display = 'inline';
                      button.style.display = 'none'; 

                      const logTimeOutButton = row.querySelector('.save-time-out-btn');
                      logTimeOutButton.style.display = 'none';

                      setTimeout(function() {
                          successAlert.remove();
                      }, 2000);
                    } else {
                        const errorAlert = document.createElement('div');
                        errorAlert.classList.add('alert', 'alert-danger');
                        errorAlert.setAttribute('role', 'alert');
                        errorAlert.style.marginTop = '10px';
                        errorAlert.textContent = data.message;

                        const table = document.querySelector('.table');
                        if (table && table.parentNode) {
                            table.parentNode.insertBefore(errorAlert, table);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        // Show 'Log Time Out' button if time is selected'
        const timeOutInputs = document.querySelectorAll('.time-out-input');
        timeOutInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                const row = input.closest('tr');
                const saveButton = row.querySelector('.save-time-out-btn');
                saveButton.style.display = input.value ? 'block' : 'none';
            });

            if (!input.value) {
                const row = input.closest('tr');
                const saveButton = row.querySelector('.save-time-out-btn');
                saveButton.style.display = 'none';
            }
        });
    });
    </script>
  </body>
</html>
