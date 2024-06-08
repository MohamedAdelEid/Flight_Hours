<div>
    <section class="w-full">
        <div class="mx-auto max-w-screen-xl w-full">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms = 'search' type="text"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-500 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Search" required="">
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900 dark:text-white">نوع الوظيفة</label>
                            <select wire:model.live = "job_type"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-500 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="">All</option>
                                @forelse($jobTypes as $job_type)
                                    <option value="{{ $job_type->id }}">{{ $job_type->job_type }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-500">
                            <tr
                                class="text-sm text-center font-semibold tracking-wide text-gray-500 border-b dark:border-gray-700 bg-gray-200 dark:text-white dark:bg-gray-900">
                                <th scope="col" class="px-4 py-3">الاسم</th>
                                <th scope="col" class="px-4 py-3">نوع الوظيفة</th>
                                <th scope="col" class="px-4 py-3">حالة الوظيفة</th>
                                <th scope="col" class="px-4 py-3">الموظف</th>
                                <th scope="col" class="px-4 py-3">وقت الإضافة</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">إجراءات</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-center divide-y dark:divide-gray-700 dark:bg-gray-700">
                            @forelse ($jobs as $job)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <th scope="row" class="px-4 py-3">
                                        <p class="font-semibold">{{ $job->job_name }}</p>
                                    </th>
                                    <td class="px-4 py-3 text-sm font-bold">{{ $job->job_type->job_type }}</td>
                                    <td class="px-4 py-3 text-xs">
                                        <span
                                            class="px-4 py-1 font-semibold leading-tight rounded-full {{ $job->status == 'active' ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : 'text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100' }}">
                                            {{ $job->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold">
                                        {{ $job->user_id }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold">{{ $job->created_at }}</td>
                                    <td class="flex justify-center px-4 py-3">
                                        <div class="w-fit flex items-center text-sm">

                                            <button
                                                class="py-1 ml-1 text-sm font-medium leading-5 text-blue-400 rounded-lg dark:text-blue-400 focus:outline-none transition duration-200 ease-in-out hover:text-blue-600"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <form action="">
                                                <button
                                                    class="py-1 mr-1 text-sm font-medium leading-5 text-red-400 rounded-lg dark:text-red-400 focus:outline-none transition duration-200 ease-in-out hover:text-red-600"
                                                    aria-label="Delete">
                                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="20" class="text-xl dark:text-white text-gray-700 py-4">
                                        لا يوجد وظائف
                                    </th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <select wire:model.live ="perPage"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-500 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 me-3">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label class="w-32 text-sm font-medium text-gray-900 dark:text-white">لكل صفحة</label>
                        </div>
                    </div>
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </section>

</div>
