<template>
    <div class="relative h-screen text-black dark:text-white">
        <nav class="flex flex-row flex-wrap items-center fixed top-0 w-full z-40 bg-white dark:bg-slate-800">
            <div class="flex-none flex items-center w-auto md:w-64 px-4 md:px-6 py-4 border-b md:border-b-0 border-r-0 md:border-r border-slate-300 dark:border-slate-700">
                <button @click="state.layout.menu = !state.layout.menu" class="block md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="state.layout.menu ? 'M4 6h16M4 12h8m-8 6h16' : 'M4 6h16M4 12h16M4 18h7'" />
                    </svg>
                </button>

                <router-link :to="{ name: 'admin.dashboard.index' }" class="ml-3 md:ml-0">
                    <h6 class="text-sm font-semibold">Dashboard {{ store.getters['auth/level'] == 'admin' ? 'Admin' : 'Kurir' }}</h6>
                    <p class="text-2xs text-slate-700 dark:text-slate-300">Toko depot isi ulang air mineral.</p>
                </router-link>
            </div>

            <div class="flex-1 flex flex-row flex-wrap justify-end md:justify-between items-center space-x-2 px-4 md:px-6 py-4 md:py-2.5 border-b border-slate-300 dark:border-slate-700">
                <button @click="state.search.modal = mobile ? (!state.search.modal) : false" class="flex items-center space-x-3 w-auto md:w-96 px-2 md:px-4 py-2 md:py-3 rounded-full cursor-pointer md:cursor-default text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700/50 focus:outline-none focus-within:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <input v-model="state.search.data" @keyup.enter="search" type="text" placeholder="Cari untuk ID atau Nama Produk, ID atau Nama Kendaraan..." class="hidden md:block w-full text-xs font-semibold bg-transparent appearance-none placeholder-slate-700 dark:placeholder-slate-300 focus:outline-none">
                </button>

                <div class="flex justify-between items-center space-x-2 md:space-x-3">
                    <div v-if="store.getters['auth/level'] == 'kurir'" class="static md:relative w-auto">
                        <button @click="showChatDialog" class="flex items-center space-x-1.5 relative w-auto px-2 md:px-2.5 py-2 md:py-3 rounded-full md:rounded-lg cursor-pointer bg-slate-100 dark:bg-slate-700/50 md:bg-transparent md:dark:bg-transparent focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>

                            <h6 class="hidden md:block text-xs font-semibold">Pesan</h6>

                            <div v-if="state.chat.newLength > 0" class="flex justify-center items-center top-0 right-2 w-4 aspect-square rounded-full text-2xs z-20 text-white bg-rose-500">{{ state.chat.newLength }}</div>
                        </button>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <div v-show="state.chat.modal" class="fixed md:absolute top-auto md:top-[3.75rem] bottom-0 md:bottom-auto right-0 w-full md:w-80 rounded-t-md rounded-b-none overflow-hidden md:rounded-md shadow-none md:shadow-md -z-10 bg-white dark:bg-slate-800" id="chat-container">
                                <div v-show="! state.chat.conversation.active" class="block space-y-4">
                                    <div class="flex justify-between items-center px-4 py-3 bg-slate-300/50 dark:bg-slate-900/50" id="swipe-chat">
                                        <div>
                                            <h6 class="text-sm font-semibold">Pesan Ke Pelanggan</h6>
                                            <p class="text-2xs text-slate-700 dark:text-slate-300">Pelanggan dapat mengirimkan pesan ketika kurir aktif.</p>
                                        </div>

                                        <button @click="state.chat.modal = false" class="cursor-pointer focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="relative mx-4">
                                        <Combobox v-model="state.chat.search.value">
                                            <div class="flex items-center space-x-3 w-full px-4 py-3 rounded-full text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700/50 focus:outline-none focus-within:text-black">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>

                                                <ComboboxInput @change="state.chat.search.query = $event.target.value" class="w-full text-xs font-semibold bg-transparent appearance-none placeholder-slate-700 dark:placeholder-slate-300 focus:outline-none" placeholder="Cari nama pelanggan" />

                                                <ComboboxButton>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                                    </svg>
                                                </ComboboxButton>
                                            </div>

                                            <TransitionRoot
                                                leave="transition ease-in duration-100"
                                                leaveFrom="opacity-100"
                                                leaveTo="opacity-0"
                                                @after-leave="state.chat.search.query = ''"
                                            >
                                                <ComboboxOptions class="absolute left-0 w-full py-1 overflow-auto bg-white rounded-md shadow-lg top-11 max-h-60 dark:bg-slate-700 focus:outline-none">
                                                    <div v-if="filterChatUser.length === 0 && state.chat.search.query !== ''" class="p-4 text-center text-xs text-slate-700 dark:text-slate-300">
                                                        Nama pelanggan tidak tersedia.
                                                    </div>

                                                    <ComboboxOption v-for="(user, index) in filterChatUser" :key="index" :value="user" @click="connectMessage(user.id)" class="relative flex items-center space-x-2.5 py-2 pl-10 pr-4 overflow-hidden cursor-pointer group">
                                                        <img :src="user?.avatar" referrerpolicy="no-referrer" class="w-8 aspect-square rounded-full object-cover">

                                                        <div>
                                                            <h6 class="truncate text-xs font-semibold text-black dark:text-white">{{ user.nama_lengkap }}</h6>
                                                            <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ user.email }}</p>
                                                        </div>
                                                    </ComboboxOption>
                                                </ComboboxOptions>
                                            </TransitionRoot>
                                        </Combobox>
                                    </div>

                                    <div class="block space-y-3 h-80 px-4 overflow-y-auto text-black dark:text-white">
                                        <button v-for="(chat, index) in state.chat.messages.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))" :key="index" @click="connectMessage(chat.id)" class="flex items-center space-x-3 w-full px-4 py-3.5 md:py-3 rounded-lg bg-slate-200 dark:bg-slate-900/50">
                                            <img :src="chat.avatar" referrerpolicy="no-referrer" class="w-10 aspect-square rounded-full object-cover">

                                            <div class="block w-full space-y-0.5 overflow-hidden">
                                                <div class="flex justify-between items-center space-x-2.5">
                                                    <h6 class="truncate text-xs font-semibold">{{ chat.nama_depan + ' ' + (chat.nama_belakang ?? '') }}</h6>
                                                    
                                                    <p class="text-2xs text-slate-700 dark:text-slate-300">{{ day(chat.created_at).format('HH:mm') }}</p>
                                                </div>

                                                <div class="flex justify-between items-center space-x-2.5">
                                                    <p class="truncate text-left text-xs text-slate-700 dark:text-slate-300">{{ (chat.pengirim == 'admin' ? 'anda:' : 'pelanggan:') + ' ' + chat.pesan }}</p>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div v-show="state.chat.conversation.active" class="block space-y-5">
                                    <div class="flex justify-between items-center px-4 py-3 bg-slate-300/50 dark:bg-slate-900/50" id="swipe-chat">
                                        <div class="flex items-center space-x-3">
                                            <button @click="state.chat.conversation.active = false" class="focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                </svg>
                                            </button>

                                            <div class="flex items-center space-x-3">
                                                <img :src="state.chat.conversation.user?.avatar" referrerpolicy="no-referrer" class="w-8 aspect-square rounded-full object-cover">

                                                <div>
                                                    <h6 class="text-sm font-semibold">{{ state.chat.conversation.user?.nama_depan + ' ' + (state.chat.conversation.user?.nama_belakang ?? '') }}</h6>
                                                    <p class="text-2xs text-slate-700 dark:text-slate-300">{{ state.chat.conversation.user?.email }} &middot; {{ state.chat.conversation.user?.no_telpon ?? 'no telp kosong' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button @click="state.chat.modal = false" class="cursor-pointer focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="block space-y-3 h-80 px-4 overflow-y-auto text-black dark:text-white">
                                        <div v-for="(message, index) in state.chat.conversation.messages" :key="index" :class="message.pengirim == 'admin' ? 'float-right' : 'float-left'" class="relative min-w-[90px] max-w-[83.333333%] px-3 py-2.5 clear-both text-xs rounded-lg bg-slate-200 dark:bg-slate-900/50">
                                            <p>{{ message.pesan }}</p>

                                            <div class="text-right text-2xs text-slate-700 dark:text-slate-300">{{ day(message.created_at).format(
                                                day(new Date()).format('YYYYMMDD') == day(message.created_at).format('YYYYMMDD') ? 'HH:mm' : 'DD MMM, HH:mm'
                                            ) }}</div>
                                        </div>
                                    </div>

                                    <Form :validation-schema="schemaChat" v-slot="{ errors, resetForm }" @submit="v => sendMessage(v, resetForm)" class="flex items-center space-x-2.5 clear-both px-4 py-3 bg-slate-200 dark:bg-slate-900/50">
                                        <div :class="errors['pesan'] ? 'border-rose-500' : 'border-transparent'" class="w-full px-4 py-2 md:py-1.5 border rounded-full bg-slate-300 dark:bg-slate-900">
                                            <Field name="pesan" class="w-full text-xs font-semibold text-white bg-transparent focus:outline-none" placeholder="Ketik pesan.." />
                                        </div>

                                        <button type="submit" class="p-2.5 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </button>
                                    </Form>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <Menu as="div" v-slot="{ open }" class="relative w-full md:w-auto">
                        <MenuButton @click="state.chat.modal = false" class="flex items-center space-x-2 w-full md:w-auto">
                            <img :src="store.getters['auth/user'].avatar" referrerpolicy="no-referrer" alt="Foto Profil" class="w-8 aspect-square rounded-full">

                            <div class="hidden md:block text-left">
                                <h6 class="text-xs font-semibold">{{ store.getters['auth/user'].nama_depan + ' ' + (store.getters['auth/user'].nama_belakang ?? '') }}</h6>
                                <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['auth/user'].email }}</p>
                            </div>

                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-180' : ''" class="h-3.5 w-3.5 transition-transform duration-300 ease-in-out text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </MenuButton>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems v-show="open" class="block space-y-1.5 absolute top-[3.75rem] right-0 origin-top-right w-56 border rounded-md overflow-hidden shadow-lg z-20 border-slate-300/50 dark:border-slate-700/50 bg-white dark:bg-slate-800 focus:outline-none" static>
                                <MenuItem>
                                    <router-link :to="{ name: 'admin.dashboard.setting' }" class="flex items-center space-x-3 w-full md:w-auto px-4 py-3">
                                        <img :src="store.getters['auth/user'].avatar" referrerpolicy="no-referrer" alt="Foto Profil" class="w-8 aspect-square rounded-full">

                                        <div class="text-left">
                                            <h6 class="text-xs font-semibold">{{ store.getters['auth/user'].nama_depan + ' ' + (store.getters['auth/user'].nama_belakang ?? '') }}</h6>
                                            <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['auth/user'].email }}</p>
                                        </div>
                                    </router-link>
                                </MenuItem>

                                <hr class="mx-4 border-slate-300/50 dark:border-slate-700/50">

                                <div>
                                    <div class="flex items-center justify-between w-full px-4 py-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
                                        <div class="flex items-center space-x-3">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                                </svg>
                                            </div>

                                            <div>
                                                <h6 class="text-xs font-bold">Mode Gelap</h6>
                                                <p class="text-2xs text-slate-700 dark:text-slate-300">Menyesuaikan system.</p>
                                            </div>
                                        </div>

                                        <div>
                                            <Switch v-model="state.layout.dark" :class="state.layout.dark ? 'bg-slate-700' : 'bg-slate-200'" class="relative flex items-center h-4 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer w-7 focus:outline-none">
                                                <span class="sr-only">Use setting</span>
                                                <span aria-hidden="true" :class="state.layout.dark ? 'translate-x-3.5' : 'translate-x-0'" class="pointer-events-none inline-block w-2.5 h-2.5 rounded-full transform transition ease-in-out duration-200 bg-slate-700 dark:bg-white" />
                                            </Switch>
                                        </div>
                                    </div>

                                    <MenuItem>
                                        <router-link :to="{ name: 'admin.dashboard.setting' }" class="flex items-center w-full px-4 py-3 space-x-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>

                                            <div>
                                                <h6 class="text-xs font-bold">Pengaturan</h6>
                                                <p class="text-2xs text-slate-700 dark:text-slate-300">Pengaturan yang digunakan.</p>
                                            </div>
                                        </router-link>
                                    </MenuItem>

                                    <MenuItem>
                                        <router-link :to="{ name: 'admin.dashboard.about' }" class="flex items-center space-x-3 w-full px-4 py-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>

                                            <div>
                                                <h6 class="text-xs font-bold">Tentang</h6>
                                                <p class="text-2xs text-slate-700 dark:text-slate-300">App versi 1.0.0 &middot; beta by husni</p>
                                            </div>
                                        </router-link>
                                    </MenuItem>
                                </div>

                                <hr class="mx-4 border-slate-300/50 dark:border-slate-700/50">

                                <MenuItem>
                                    <button @click="logout" class="flex items-center w-full px-4 py-3 space-x-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </div>

                                        <h6 class="text-xs font-bold text-rose-500">Log out</h6>
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </nav>

        <div class="h-screen flex flex-row pt-16">
            <div :class="state.layout.menu ? 'flex fixed' : 'hidden'" class="md:flex flex-col flex-wrap flex-none w-64 border-r z-40 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                <div class="flex flex-col sticky top-16 px-6 py-5 h-[calc(100vh-64px)]">
                    <p class="uppercase text-xs mb-4 tracking-wider text-slate-700 dark:text-slate-300">homes</p>

                    <router-link :to="{ name: 'admin.dashboard.index' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.index' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        
                        <h6 class="text-sm font-semibold">Beranda</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.courier' }" v-if="store.getters['auth/level'] == 'kurir'" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.courier' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <h6 class="text-sm font-semibold">Kurir</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.transaction' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.transaction' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                        </svg>

                        <h6 class="text-sm font-semibold">Transaksi</h6>
                    </router-link>

                    <p class="uppercase text-xs mb-4 mt-4 tracking-wider text-slate-700 dark:text-slate-300">apps</p>

                    <router-link :to="{ name: 'admin.dashboard.information' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.information' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>

                        <h6 class="text-sm font-semibold">Informasi</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.product' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.product' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        
                        <h6 class="text-sm font-semibold">Produk</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.vehicle' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.vehicle' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>

                        <h6 class="text-sm font-semibold">Kendaraan</h6>
                    </router-link>

                    <!-- <router-link :to="{ name: 'admin.dashboard.spending' }" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.spending' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        
                        <h6 class="text-sm font-semibold">Pengeluaran</h6>
                    </router-link> -->

                    <router-link :to="{ name: 'admin.dashboard.member' }" v-if="store.getters['auth/level'] == 'admin'" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.member' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>

                        <h6 class="text-sm font-semibold">Anggota</h6>
                    </router-link>

                    <p v-if="store.getters['auth/level'] == 'admin'" class="uppercase text-xs mb-4 mt-4 tracking-wider text-slate-700 dark:text-slate-300">laporan</p>

                    <router-link :to="{ name: 'admin.dashboard.report.product' }" v-if="store.getters['auth/level'] == 'admin'" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.report.product' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>

                        <h6 class="text-sm font-semibold">Laporan Produk</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.report.transaction' }" v-if="store.getters['auth/level'] == 'admin'" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.report.transaction' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>

                        <h6 class="text-sm font-semibold">Laporan Transaksi</h6>
                    </router-link>

                    <router-link :to="{ name: 'admin.dashboard.report.vehicle' }" v-if="store.getters['auth/level'] == 'admin'" @click="state.layout.menu = false" :class="$route.name === 'admin.dashboard.report.vehicle' ? 'text-blue-500 dark:text-blue-400' : ''" class="flex items-center space-x-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>

                        <h6 class="text-sm font-semibold">Laporan Kendaraan</h6>
                    </router-link>
                </div>
            </div>

            <main class="flex-1 overflow-x-auto bg-slate-100 dark:bg-slate-900" style="overflow-y: overlay;">
                <router-view :key="$route.params.slug || 'default'" v-slot="{ Component }">
                    <transition name="fade" mode="out-in">
                        <component :is="Component" />
                    </transition>
                </router-view>
            </main>
        </div>

        <TransitionRoot appear :show="state.search.modal" as="template">
            <Dialog as="div" @close="state.search.modal = false">
                <div class="flex justify-center items-center fixed inset-0 px-4 z-50">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 backdrop-filter backdrop-blur-[1px]" />
                    </TransitionChild>

                    <span class="inline-block h-screen align-middle" aria-hidden="true">
                        &#8203;
                    </span>

                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <div class="inline-block space-y-3 w-full max-w-md p-4 align-middle transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h6 class="text-sm font-semibold">Pencarian</h6>
                                    <p class="text-2xs text-slate-700 dark:text-slate-300">Pencarian global keyword.</p>
                                </div>

                                <button @click="state.search.modal = false" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center space-x-3 w-full px-4 py-3 rounded-full text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700/50 focus:outline-none focus-within:text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>

                                <input v-model="state.search.data" @keyup.enter="search" type="text" placeholder="Cari untuk ID atau Nama Produk, ID atau Nama Kendaraan..." class="w-full text-xs font-semibold bg-transparent appearance-none placeholder-slate-700 dark:placeholder-slate-300 focus:outline-none">
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <ModalNotification
            :modal="state.notification.modal"
            :type="state.notification.type"
            @event-modal="v => state.notification.modal = v"
        />
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { useRouter } from 'vue-router'
    import { computed, inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'
    import Pusher from 'pusher-js'

    import hammer from 'hammerjs'

    import { Device } from '@capacitor/device'
    import { StatusBar } from '@capacitor/status-bar'
    import { LocalNotifications } from '@capacitor/local-notifications'

    import { object, string } from 'yup'

    import ModalNotification from '~/components/notification/ModalNotification'
    import { Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, Menu, MenuButton, MenuItems, MenuItem, Switch, TransitionRoot, TransitionChild, Dialog, DialogOverlay } from '@headlessui/vue'

    export default {
        middleware: 'auth:admin',

        components: {
            ModalNotification,
            Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, Menu, MenuButton, MenuItems, MenuItem, Switch, TransitionRoot, TransitionChild, Dialog, DialogOverlay
        },

        setup() {
            let elementHtml = document.querySelector('html').classList
            let appBarColor = document.querySelector(`meta[name='theme-color']`)

            const day        = inject('day')
            const mobile     = inject('mobile')
            const pusher     = inject('pusher')

            const router     = useRouter()
            const store      = useStore()

            const state      = reactive({
                layout: {
                    dark: false,
                    menu: false
                },

                search: {
                    data: null,
                    modal: false
                },

                notification: {
                    type: '',
                    modal: false
                },

                chat: {
                    modal: false,
                    newLength: 0,
                    messages: [],

                    search: {
                        user: [],
                        query: '',
                        value: null
                    },

                    conversation: {
                        active: false,
                        user: null,
                        messages: null
                    }
                },
            })

            const schemaChat = object({
                pesan: string().required()
            })

            watch(() => state.layout.dark, (value) => {
                localStorage.setItem('theme', value ? 'dark' : 'light')
                appBarColor.setAttribute('content', value ? '#111827' : '#FFFFFF')

                if (value) {
                    elementHtml.add('dark')
                    StatusBar.setStyle({ style: 'DARK' })
                    StatusBar.setBackgroundColor({ color: '#1E293B' })
                } else {
                    elementHtml.remove('dark')
                    StatusBar.setStyle({ style: 'LIGHT' })
                    StatusBar.setBackgroundColor({ color: '#FFFFFF' })
                }
            })

            const search = () => {
                axios.post('/api/admin/search', { query: state.search.data }).then(({ data }) => {
                    store.dispatch('search/saveDataSearch', data.results)

                    router.push({ path: '/' + data.type + '/' + state.search.data })
                }).catch(() => {
                    router.push({ path: '/404' })
                })
            }

            const showChatDialog = () => {
                state.chat.modal     = ! state.chat.modal
                state.chat.newLength = 0

                if (state.chat.search.user.length <= 0) {
                    axios.get('/api/admin/chat/user').then(({ data }) => {
                        state.chat.search.user = data.results
                    })
                }
            }

            const filterChatUser = computed(() => {
                return state.chat.search.query == '' ? state.chat.search.user : state.chat.search.user.filter(val => {
                    return val.nama_lengkap.toLowerCase().replace(/\s+/g, '').includes(
                        state.chat.search.query.toLowerCase().replace(/\s+/g, '')
                    )
                })
            })

            const connectMessage = (id) => {
                axios.get('/api/admin/chat/' + id).then(({ data }) => {
                    state.chat.conversation = {
                        active: true,
                        user: data.results.user,
                        messages: data.results.messages
                    }
                })
            }

            const sendMessage = (values, resetForm) => {
                axios.post('/api/admin/chat', {
                    ...values, id_user: state.chat.conversation.user.id
                }).then(({ data }) => {
                    let getUser = state.chat.messages.findIndex(v => v.id_user == state.chat.conversation.user.id)

                    let payload = {
                        pesan: values.pesan,
                        pengirim: 'admin',
                        created_at: new Date()
                    }

                    if (getUser >= 0) {
                        state.chat.messages[getUser] = {
                            ...state.chat.messages[getUser], ...payload
                        }
                    }

                    state.chat.conversation.messages.push({
                        ...values, ...payload
                    })

                    resetForm({
                        values: { pesan: '' }
                    })
                })
            }

            const logout = async () => {
                await store.dispatch('auth/logout')

                router.push({ name: 'admin.auth.login' })
            }

            onMounted(async () => {
                let device         = (await Device.getInfo()).platform
                let mediaDarkTheme = window.matchMedia('(prefers-color-scheme: dark)').matches

                let channel = new Pusher('29fd29eb69f3c3e55dd1', {
                    ...pusher, auth: {
                        headers: {
                            Authorization: 'Bearer ' + store.getters['auth/token']
                        }
                    }
                })

                if (mediaDarkTheme && localStorage.getItem('theme') == null) {
                    localStorage.setItem('theme', 'dark')

                    elementHtml.add('dark')
                    appBarColor.setAttribute('content', '#111827')

                    state.layout.dark = true
                } else if (localStorage.getItem('theme') == 'dark') {
                    elementHtml.add('dark')
                    appBarColor.setAttribute('content', '#111827')

                    state.layout.dark = true
                }

                if (device == 'android') {
                    await LocalNotifications.requestPermissions()

                    await LocalNotifications.registerActionTypes({
                        types: [
                            {
                                id: 'actionNotification',
                                actions: [
                                    {
                                        id: 'dismiss',
                                        title: 'Hapus',
                                        destructive: true
                                    },
                                    {
                                        id: 'open',
                                        title: 'Buka'
                                    }
                                ]
                            }
                        ]
                    })

                    let stage      = document.getElementById('chat-container')
                    let swipeStage = document.getElementById('swipe-chat')

                    let swipe = new hammer.Manager(swipeStage, {
                        recognizers: [
                            [hammer.Pan, { direction: hammer.DIRECTION_VERTICAL }],
                            [hammer.Swipe, { direction: hammer.DIRECTION_VERTICAL, threshold: 70 }, ['pan'] ],
                        ]
                    })

                    swipe.on('pan', (ev) => {
                        if (ev.deltaY >= 0) {
                            stage.style.transition = 'none'
                            stage.style.transform  = 'translateY(' + ev.deltaY + 'px)'
                        }
                    })

                    swipe.on('panend', () => {
                        stage.style.transition = 'transform .2s'
                        stage.style.transform  = 'translateY(0)'
                        stage.style.opacity    = 1
                    })

                    swipe.on('swipedown', () => {
                        stage.style.transition = 'transform .26s ease-out, opacity .26s'
                        stage.style.transform  = 'translateY(140%)'
                        stage.style.opacity    = 0

                        state.chat.modal       = false

                        setTimeout(() => {
                            stage.style.opacity    = 1
                            stage.style.transform  = 'translateY(0)'
                        }, 500)
                    })
                }

                if (store.getters['auth/level'] == 'kurir') {
                    axios.get('/api/admin/chat').then(({ data }) => {
                        state.chat.messages = data.results
                    })

                    channel.subscribe('private-chatCourier.' + store.getters['auth/user'].id)
                        .bind('App\\Events\\CourierMessage', ({ from, message }) => {
                            let getUser = state.chat.messages.findIndex(v => v.id_user == from.id)

                            let payload = {
                                pesan: message,
                                pengirim: 'user',
                                created_at: new Date()
                            }

                            state.chat.newLength += 1

                            if (getUser >= 0) {
                                state.chat.messages[getUser] = {
                                    ...state.chat.messages[getUser], ...payload
                                }
                            } else {
                                let getSearchUser = state.chat.search.user.findIndex(v => v.id == from.id)

                                if (getSearchUser < 0) {
                                    state.chat.search.user.push({
                                        id: from.id,
                                        nama_lengkap: from.nama_depan + ' ' + (from.nama_belakang ?? ''),
                                        email: from.email,
                                        avatar: from.avatar
                                    })
                                }

                                state.chat.messages.push({
                                    ...from, ...payload
                                })
                            }

                            if (state.chat.conversation.active && state.chat.conversation.user.id == from.id) {
                                state.chat.conversation.messages.push(payload)
                            }

                            if (device == 'android') {
                                LocalNotifications.schedule({
                                    notifications: [
                                        {
                                            id: 0,
                                            title: 'Pesan pelanggan dari ' + from.nama_depan,
                                            body: message.substring(0, 25),
                                            actionTypeId: 'actionNotification'
                                        }
                                    ]
                                })
                            }
                        })
                } else {
                    let buyers = []

                    channel.subscribe('buyer').bind('App\\Events\\BuyerLocation', ({ user, status }) => {
                        let getIndexBuyer = buyers.findIndex(v => v == user.id)

                        console.log(getIndexBuyer, status)

                        if (status) {
                            if (getIndexBuyer <= -1) {
                                buyers.push(user.id)

                                state.notification = {
                                    type: 'new-buyer',
                                    modal: true
                                }
                            }
                        } else {
                            if (getIndexBuyer > -1) {
                                buyers.splice(getIndexBuyer, 1)
                            }
                        }
                    })
                }
            })

            return {
                day, mobile,
                store, state,
                schemaChat,
                search,
                showChatDialog, filterChatUser, connectMessage, sendMessage,
                logout
            }
        }
    }
</script>
