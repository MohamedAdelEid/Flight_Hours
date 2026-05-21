@extends('layouts.employee.main')

@section('alerts')
    @if (Session::has('success'))
        <script>
            iziToast.success({
                title: "{{ session('success') }}",
                position: 'topRight',
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                iziToast.error({
                    title: "خطأ",
                    message: "{{ $error }}",
                    position: 'topRight',
                });
            </script>
        @endforeach
    @endif
    @if ($errors->has('profile'))
        @foreach ($errors->profile->all() as $error)
            <script>
                iziToast.error({
                    title: "خطأ",
                    message: "{{ $error }}",
                    position: 'topRight',
                });
            </script>
        @endforeach
    @endif
@endsection

@section('content')
<main>
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mx-auto max-w-242.5">
            <div class="overflow-hidden rounded-sm border border-stroke shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="relative z-20 h-[250px]">
                    <img src="{{ asset('assets/imgs/employee/airport cover.jpg') }}" alt="profile cover"
                        class="h-full w-full rounded-tl-sm rounded-tr-sm object-cover object-center" />

                    <div class="flex justify-end m-3">
                        <button id="settingsBtn"
                            class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-200 bg-blue-600 border border-transparent rounded-md active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                            الاعدادات <i class="fa-solid fa-gear"></i>
                        </button>
                    </div>
                </div>
                <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5 -mt-24">
                    <div class="relative z-30 mx-auto -mt-22 h-30 w-fit rounded-full sm:h-44 sm:p-3">
                        <form onchange="submit()" method="post" action="{{ route('admin.changePhoto') }}" enctype="multipart/form-data" class="relative drop-shadow-2">
                            @csrf
                            @if ($admin->image)
                                <img src="{{ asset('storage/' . $admin->image) }}" alt="ProfileImage"
                                    class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-indigo-300 dark:ring-indigo-500">
                            @else
                                <div class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-indigo-300 dark:ring-indigo-500 bg-indigo-600 flex items-center justify-center text-white text-5xl font-bold">
                                    {{ mb_substr($admin->name, 0, 1) }}
                                </div>
                            @endif
                            <label for="profile"
                                class="absolute bottom-0 right-0 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-blue-500 text-white transition duration-200 ease-in-out hover:bg-blue-700 sm:bottom-2 sm:right-2 ">
                                <svg class="fill-current" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.76464 1.42638C4.87283 1.2641 5.05496 1.16663 5.25 1.16663H8.75C8.94504 1.16663 9.12717 1.2641 9.23536 1.42638L10.2289 2.91663H12.25C12.7141 2.91663 13.1592 3.101 13.4874 3.42919C13.8156 3.75738 14 4.2025 14 4.66663V11.0833C14 11.5474 13.8156 11.9925 13.4874 12.3207C13.1592 12.6489 12.7141 12.8333 12.25 12.8333H1.75C1.28587 12.8333 0.840752 12.6489 0.512563 12.3207C0.184375 11.9925 0 11.5474 0 11.0833V4.66663C0 4.2025 0.184374 3.75738 0.512563 3.42919C0.840752 3.101 1.28587 2.91663 1.75 2.91663H3.77114L4.76464 1.42638ZM5.56219 2.33329L4.5687 3.82353C4.46051 3.98582 4.27837 4.08329 4.08333 4.08329H1.75C1.59529 4.08329 1.44692 4.14475 1.33752 4.25415C1.22812 4.36354 1.16667 4.51192 1.16667 4.66663V11.0833C1.16667 11.238 1.22812 11.3864 1.33752 11.4958C1.44692 11.6052 1.59529 11.6666 1.75 11.6666H12.25C12.4047 11.6666 12.5531 11.6052 12.6625 11.4958C12.7719 11.3864 12.8333 11.238 12.8333 11.0833V4.66663C12.8333 4.51192 12.7719 4.36354 12.6625 4.25415C12.5531 4.14475 12.4047 4.08329 12.25 4.08329H9.91667C9.72163 4.08329 9.53949 3.98582 9.4313 3.82353L8.43781 2.33329H5.56219Z"
                                        fill=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M7.00004 5.83329C6.03354 5.83329 5.25004 6.61679 5.25004 7.58329C5.25004 8.54979 6.03354 9.33329 7.00004 9.33329C7.96654 9.33329 8.75004 8.54979 8.75004 7.58329C8.75004 6.61679 7.96654 5.83329 7.00004 5.83329ZM4.08337 7.58329C4.08337 5.97246 5.38921 4.66663 7.00004 4.66663C8.61087 4.66663 9.91671 5.97246 9.91671 7.58329C9.91671 9.19412 8.61087 10.5 7.00004 10.5C5.38921 10.5 4.08337 9.19412 4.08337 7.58329Z"
                                        fill=""></path>
                                </svg>
                                <input type="file" accept="image/*" name="profile" id="profile" class="sr-only">
                            </label>
                        </form>
                    </div>
                    <div class="mt-2">
                        <h3 class="mb-1.5 text-2xl font-medium text-black dark:text-white">
                            {{ $admin->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">مدير النظام</p>

                        <div class="grid grid-cols-5 gap-8">
                            <div class="col-span-5 xl:col-span-5">
                                <div class="rounded-sm shadow-default dark:bg-boxdark">
                                    <div class="p-7">
                                        <div class="mb-5 flex flex-col gap-5 sm:flex-row">
                                            <div class="w-full sm:w-1/2">
                                                <x-employee.profile.personal-info name="الأسم"
                                                    icon="fa-solid fa-user me-2" value="{{ $admin->name }}" />
                                            </div>

                                            <div class="w-full sm:w-1/2">
                                                <x-employee.profile.personal-info name="رقم الهاتف"
                                                    icon="fa-solid fa-phone me-2"
                                                    value="{{ $admin->phone ?? 'N/A' }}" />
                                            </div>
                                        </div>

                                        <div class="mb-5.5">
                                            <x-employee.profile.personal-info name="البريد الالكتروني"
                                                icon="fa-solid fa-envelope me-2" value="{{ $admin->email }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Settings Modal -->
<div id="settingsModal" class="fixed inset-0 z-[5000] hidden items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="w-full max-w-lg mx-4 rounded-xl bg-[#1e2433] shadow-2xl">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h2 class="text-lg font-semibold text-white">تعديل البيانات الشخصية</h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-5">
            <!-- Profile Image -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    @if ($admin->image)
                        <img src="{{ asset('storage/' . $admin->image) }}" alt="Profile"
                            class="w-28 h-28 rounded-full object-cover ring-4 ring-blue-500/30">
                    @else
                        <div class="w-28 h-28 rounded-full bg-indigo-600 flex items-center justify-center text-white text-4xl font-bold ring-4 ring-blue-500/30">
                            {{ mb_substr($admin->name, 0, 1) }}
                        </div>
                    @endif
                    <label for="modalProfile" class="absolute -bottom-1 -right-1 w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-600 transition-colors ring-2 ring-[#1e2433]">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                    <form id="modalPhotoForm" action="{{ route('admin.changePhoto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" accept="image/*" name="profile" id="modalProfile" onchange="document.getElementById('modalPhotoForm').submit()">
                    </form>
                </div>
            </div>

            <!-- Form -->
            <form id="updateProfileForm" action="{{ route('admin.update-profile') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">الأسم</label>
                    <input type="text" name="name" value="{{ $admin->name }}"
                        class="w-full px-4 py-3 bg-[#2a3142] border border-white/5 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                    @error('name')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">البريد الالكتروني</label>
                    <input type="email" name="email" value="{{ $admin->email }}"
                        class="w-full px-4 py-3 bg-[#fef9c3] border border-yellow-200/30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all">
                    @error('email')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">الرقم</label>
                    <input type="text" name="phone" value="{{ $admin->phone ?? '' }}"
                        class="w-full px-4 py-3 bg-[#2a3142] border border-white/5 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                    @error('phone')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- Old Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">كلمة السر القديمة</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="oldPassword"
                            class="w-full px-4 py-3 pr-12 bg-[#fef9c3] border border-yellow-200/30 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all">
                        <button type="button" onclick="togglePassword('oldPassword', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300">
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-300 mb-2">كلمة السر الجديدة</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="newPassword"
                            class="w-full px-4 py-3 pr-12 bg-[#2a3142] border border-white/5 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all">
                        <button type="button" onclick="togglePassword('newPassword', this)" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300">
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('new_password')<span class="text-red-400 text-xs mt-1">{{ $message }}</span>@enderror
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-white/5">
            <button onclick="closeModal()" class="px-5 py-2.5 text-sm font-medium text-gray-300 border border-gray-600 rounded-lg hover:bg-white/5 transition-colors">
                إلغاء
            </button>
            <button type="submit" form="updateProfileForm" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                حفظ
            </button>
        </div>
    </div>
</div>

<script>
    const settingsBtn = document.getElementById('settingsBtn');
    const settingsModal = document.getElementById('settingsModal');

    settingsBtn.addEventListener('click', function() {
        settingsModal.classList.remove('hidden');
        settingsModal.classList.add('flex');
    });

    function closeModal() {
        settingsModal.classList.add('hidden');
        settingsModal.classList.remove('flex');
    }

    settingsModal.addEventListener('click', function(e) {
        if (e.target === settingsModal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            settingsModal.classList.remove('hidden');
            settingsModal.classList.add('flex');
        });
    @endif
</script>
@endsection