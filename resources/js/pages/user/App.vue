<template>
    <div class="relative h-screen select-none overflow-x-hidden text-black dark:text-white" style="overflow-y: overlay;">
        <nav class="flex justify-between items-center fixed top-0 w-full p-4 z-50 shadow-none dark:shadow-md bg-blue-500 dark:bg-slate-800">
            <div class="flex justify-between md:justify-start items-center space-x-4 w-full md:w-4/6">
                <div>
                    <h6 class="text-sm font-semibold text-white">San-Qua <span class="text-2xs">Karanganyar</span></h6>
                    <p class="text-2xs text-slate-200 dark:text-slate-300">Toko depot isi ulang air mineral.</p>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="hidden px-2.5 py-2 rounded-md bg-slate-100 dark:bg-slate-900/50 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-700 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <Menu as="div" v-slot="{ open }" class="block md:hidden relative w-full md:w-auto">
                        <MenuButton @click="state.chat.modal = false" class="flex items-center space-x-2 w-full md:w-auto">
                            <img :src="store.getters['auth/user'].avatar" referrerpolicy="no-referrer" alt="Foto Profil" class="w-8 aspect-square rounded-full">

                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-180' : ''" class="h-3.5 w-3.5 transition-transform duration-300 ease-in-out text-white dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <MenuItems v-show="open" class="block space-y-1.5 absolute top-[3.75rem] bottom-auto right-0 origin-top-right w-56 border rounded-md overflow-hidden shadow-lg z-20 border-slate-300/50 dark:border-slate-700/50 bg-white dark:bg-slate-800 focus:outline-none" static>
                                <MenuItem>
                                    <router-link :to="{ name: 'dashboard.setting' }" class="flex items-center space-x-3 w-full md:w-auto px-4 py-3">
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
                                        <router-link :to="{ name: 'dashboard.about' }" class="flex items-center space-x-3 w-full px-4 py-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
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

            <div class="flex justify-between items-center space-x-1 fixed md:relative bottom-0 left-0 w-full px-3 md:px-0 py-2 md:py-0 border-t md:border-0 border-slate-700/50 bg-white dark:bg-slate-800">
                <div class="flex justify-between items-center space-x-1 w-3/5 md:w-auto">
                    <router-link :to="{ name: 'dashboard.index' }" @click="state.chat.modal = false" :class="$route.name === 'dashboard.index' ? 'bg-slate-100 dark:bg-slate-900/50' : 'text-slate-700 dark:text-slate-300'" class="flex flex-col md:flex-row items-center space-x-0 md:space-x-1.5 w-full px-2.5 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>

                        <h6 class="text-xs font-semibold">Beranda</h6>
                    </router-link>

                    <router-link :to="{ name: 'dashboard.order' }" @click="state.chat.modal = false" :class="$route.name === 'dashboard.order' ? 'bg-slate-100 dark:bg-slate-900/50' : 'text-slate-700 dark:text-slate-300'" class="flex flex-col md:flex-row items-center space-x-0 md:space-x-1.5 w-full px-2.5 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        <h6 class="text-xs font-semibold">Order</h6>
                    </router-link>

                    <router-link :to="{ name: 'dashboard.history' }" @click="state.chat.modal = false" :class="$route.name === 'dashboard.history' ? 'bg-slate-100 dark:bg-slate-900/50' : 'text-slate-700 dark:text-slate-300'" class="flex flex-col md:flex-row items-center space-x-0 md:space-x-1.5 w-full px-2.5 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>

                        <h6 class="text-xs font-semibold">Riwayat</h6>
                    </router-link>
                </div>

                <div class="flex justify-between items-center space-x-1 md:space-x-3 w-2/5 md:w-auto">
                    <div class="static md:relative w-full md:w-auto">
                        <button @click="showChatDialog" :class="state.chat.modal ? 'bg-slate-100 dark:bg-slate-900/50' : 'text-slate-700 dark:text-slate-300'" class="flex flex-col md:flex-row items-center space-x-0 md:space-x-1.5 relative w-full md:w-auto px-2.5 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>

                            <h6 class="text-xs font-semibold">Pesan</h6>

                            <div v-if="state.chat.newLength > 0" class="flex justify-center items-center absolute md:static top-0 right-2 w-4 aspect-square rounded-full text-2xs z-20 text-white bg-rose-500">{{ state.chat.newLength }}</div>
                        </button>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <div v-show="state.chat.modal" class="absolute top-auto md:top-[3.75rem] bottom-16 md:bottom-auto right-0 w-full md:w-80 rounded-t-md rounded-b-none overflow-hidden md:rounded-md shadow-none md:shadow-md -z-10 bg-slate-100 dark:bg-slate-800" id="chat-container">
                                <div v-show="! state.chat.conversation.active" class="block space-y-4">
                                    <div class="flex justify-between items-center px-4 py-3 text-white bg-blue-500 dark:bg-slate-900/50" id="swipe-chat">
                                        <div>
                                            <h6 class="text-sm font-semibold">Pesan Ke Kurir</h6>
                                            <p class="text-2xs text-slate-200 dark:text-slate-300">Hanya bisa mengirim pesan jika kurir aktif.</p>
                                        </div>

                                        <button @click="state.chat.modal = false" class="cursor-pointer focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="relative mx-4">
                                        <Combobox v-model="state.chat.search.value">
                                            <div class="flex items-center space-x-3 w-full px-4 py-3 rounded-full text-slate-700 dark:text-slate-300 bg-slate-200 dark:bg-slate-700/50 focus:outline-none focus-within:text-black">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>

                                                <ComboboxInput @change="state.chat.search.query = $event.target.value" class="w-full text-xs font-semibold bg-transparent appearance-none placeholder-slate-700 dark:placeholder-slate-300 focus:outline-none" placeholder="Cari nama kurir" />

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
                                                <ComboboxOptions class="absolute left-0 w-full py-1 overflow-auto bg-white rounded-md shadow-lg top-11 max-h-60 z-10 dark:bg-slate-700 focus:outline-none">
                                                    <div v-if="filterChatUser.length === 0 && state.chat.search.query !== ''" class="p-4 text-center text-xs text-slate-700 dark:text-slate-300">
                                                        Nama kurir tidak tersedia.
                                                    </div>

                                                    <ComboboxOption v-for="(user, index) in filterChatUser" :key="index" :value="user" @click="connectMessage(user.id)" class="relative flex justify-between items-center py-2 pl-10 pr-4 overflow-hidden cursor-pointer group">
                                                        <div class="flex items-center space-x-2.5">
                                                            <img :src="user.avatar" referrerpolicy="no-referrer" class="w-8 aspect-square rounded-full object-cover">

                                                            <div>
                                                                <h6 class="truncate text-xs font-semibold">{{ user.nama_lengkap }}</h6>
                                                                <p class="truncate text-2xs text-slate-700 dark:text-slate-300">{{ user.email }}</p>
                                                            </div>
                                                        </div>

                                                        <div v-if="store.getters['courier/courier'].find(v => v.user.id == user.id)" class="relative pl-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-emerald-500 after:bg-emerald-500 before:bg-emerald-500">
                                                            online
                                                        </div>
                                                    </ComboboxOption>
                                                </ComboboxOptions>
                                            </TransitionRoot>
                                        </Combobox>
                                    </div>

                                    <div class="block space-y-5 h-80 px-4 overflow-y-auto text-black dark:text-white">
                                        <button v-for="(chat, index) in state.chat.messages.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))" :key="index" @click="connectMessage(chat.id)" class="flex justify-between items-center space-x-3 w-full px-4 py-3.5 md:py-3 rounded-lg bg-slate-200 dark:bg-slate-900/50">
                                            <img :src="chat.avatar" referrerpolicy="no-referrer" class="w-10 aspect-square rounded-full object-cover">

                                            <div class="block w-full space-y-0.5 overflow-hidden">
                                                <div class="flex justify-between items-center space-x-2.5">
                                                    <h6 class="truncate text-xs font-semibold">{{ chat.nama_depan + ' ' + (chat.nama_belakang ?? '') }}</h6>
                                                    
                                                    <p class="text-2xs text-slate-700 dark:text-slate-300">{{ day(chat.created_at).format('HH:mm') }}</p>
                                                </div>

                                                <div class="flex justify-between items-center space-x-2.5">
                                                    <p class="truncate text-left text-xs text-slate-700 dark:text-slate-300">{{ (chat.pengirim == 'user' ? 'anda:' : 'kurir:') + ' ' + chat.pesan }}</p>

                                                    <div v-if="store.getters['courier/courier'].find(v => v.user.id == chat.id)" class="relative pl-3 capitalize text-xs font-bold before:absolute before:top-1.5 before:-left-[-0.0625rem] before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-1.5 after:-left-[-0.0625rem] after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping text-emerald-500 after:bg-emerald-500 before:bg-emerald-500">
                                                        online
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div v-show="state.chat.conversation.active" class="block space-y-5">
                                    <div class="flex justify-between items-center px-4 py-3 text-white bg-blue-500 dark:bg-slate-900/50" id="swipe-chat">
                                        <div class="flex items-center space-x-2">
                                            <button @click="state.chat.conversation.active = false" class="p-1.5 focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                </svg>
                                            </button>

                                            <div class="flex items-center space-x-3">
                                                <img :src="state.chat.conversation.admin?.avatar" referrerpolicy="no-referrer" class="w-8 aspect-square rounded-full object-cover">

                                                <div>
                                                    <h6 class="text-sm font-semibold">{{ state.chat.conversation.admin?.nama_depan + ' ' + (state.chat.conversation.admin?.nama_belakang ?? '') }}</h6>
                                                    <p class="text-2xs text-slate-200 dark:text-slate-300">{{ store.getters['courier/courier'].find(v => v.user.id == state.chat.conversation.admin?.id)?.vehicle.nama_merk ?? 'Kurir sedang offline' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button @click="state.chat.modal = false" class="cursor-pointer focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="block space-y-3 h-80 px-4 overflow-y-auto text-black dark:text-white">
                                        <div v-for="(message, index) in state.chat.conversation.messages" :key="index" :class="message.pengirim == 'user' ? 'float-right' : 'float-left'" class="relative min-w-[90px] max-w-[83.333333%] px-3 py-2.5 clear-both text-xs rounded-lg bg-slate-200 dark:bg-slate-900/50">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-black dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </button>
                                    </Form>
                                </div>
                            </div>
                        </transition>
                    </div>

                    <router-link :to="{ name: 'dashboard.setting' }" @click="state.chat.modal = false" :class="$route.name === 'dashboard.setting' ? 'bg-slate-100 dark:bg-slate-900/50' : 'text-slate-700 dark:text-slate-300'" class="flex md:hidden flex-col md:flex-row items-center space-x-0 md:space-x-1.5 w-full px-2.5 py-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mb-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                        <h6 class="text-xs font-semibold">Pengaturan</h6>
                    </router-link>

                    <Menu as="div" v-slot="{ open }" class="hidden md:block relative w-full md:w-auto">
                        <MenuButton @click="state.chat.modal = false" class="flex flex-col md:flex-row items-center space-x-0 md:space-x-2 w-full md:w-auto">
                            <img :src="store.getters['auth/user'].avatar" referrerpolicy="no-referrer" alt="Foto Profil" class="w-8 aspect-square rounded-full">

                            <div class="hidden md:block text-left">
                                <h6 class="text-xs font-semibold">{{ store.getters['auth/user'].nama_depan + ' ' + (store.getters['auth/user'].nama_belakang ?? '') }}</h6>
                                <p class="text-2xs text-slate-700 dark:text-slate-300">{{ store.getters['auth/user'].email }}</p>
                            </div>

                            <div class="hidden md:block">
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
                            <MenuItems v-show="open" class="block space-y-1.5 absolute top-auto md:top-[3.75rem] bottom-14 md:bottom-auto right-0 origin-top-right w-56 border rounded-md overflow-hidden shadow-lg z-20 border-slate-300/50 dark:border-slate-700/50 bg-white dark:bg-slate-800 focus:outline-none" static>
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
                                        <router-link :to="{ name: 'dashboard.setting' }" class="flex items-center space-x-3 w-full px-4 py-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
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
                                        <router-link :to="{ name: 'dashboard.about' }" class="flex items-center space-x-3 w-full px-4 py-3 cursor-pointer hover:bg-slate-50 hover:dark:bg-slate-900 focus:outline-none">
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

        <main class="min-h-screen pt-16 pb-16 md:pb-0">
            <div class="flex flex-col md:flex-row relative h-auto md:h-full">
                <div :class="[$route.meta.wide ? 'md:w-3/6' : 'md:w-4/6', mobile ? ($route.meta.map ? 'z-10' : 'absolute z-0') : null, store.getters['order/orderStatus'] ? 'h-[calc(100vh-440px)]' : 'h-[calc(100vh-590px)]']" class="w-full md:h-full transition-[height] duration-500 ease-in-out">
                    <div id="map" :class="store.getters['order/orderStatus'] ? 'h-[calc(100vh-440px)]' : 'h-[calc(100vh-490px)]'" class="!absolute w-full md:h-full transition-[height] duration-500 ease-in-out"></div>

                    <div class="flex flex-col space-y-1 sticky md:absolute top-[4.75rem] md:top-4 left-4 w-auto md:w-96 mx-4 md:mx-0 p-4 mb-4 rounded-md shadow-md bg-blue-400 dark:bg-slate-800">
                        <label for="location" class="text-2xs text-slate-200 dark:text-slate-300">Lokasi Anda :</label>
                        <p class="truncate text-xs text-white">{{ state.map.place }}</p>
                    </div>
                </div>

                <router-view :key="$route.params.slug || 'default'" v-slot="{ Component }">
                    <transition name="fade" mode="out-in">
                        <component :is="Component" />
                    </transition>
                </router-view>
            </div>
        </main>

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
    import { computed, getCurrentInstance, inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import 'mapbox-gl/dist/mapbox-gl.css'

    import axios from 'axios'
    import Pusher from 'pusher-js'

    import hammer from 'hammerjs'

    import { Device } from '@capacitor/device'
    import { Haptics } from '@capacitor/haptics'
    import { Keyboard } from '@capacitor/keyboard'
    import { StatusBar } from '@capacitor/status-bar'
    import { Geolocation } from '@capacitor/geolocation'
    import { LocalNotifications } from '@capacitor/local-notifications'

    import * as turf from '@turf/turf'
    import mapboxgl from 'mapbox-gl'
    import MapboxGeocoder from '@mapbox/mapbox-gl-geocoder'
    import MapboxDirections from '@mapbox/mapbox-gl-directions/dist/mapbox-gl-directions'

    import { GoogleAuth } from '@codetrix-studio/capacitor-google-auth'
    import { FacebookLogin } from '@capacitor-community/facebook-login'

    import { object, string } from 'yup'

    import ModalNotification from '~/components/notification/ModalNotification'
    import { Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, Menu, MenuButton, MenuItems, MenuItem, Switch, TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle } from '@headlessui/vue'

    export default {
        middleware: 'auth:user',

        components: {
            ModalNotification,
            Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, Menu, MenuButton, MenuItems, MenuItem, Switch, TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle
        },

        setup() {
            let elementHtml = document.querySelector('html').classList
            let appBarColor = document.querySelector(`meta[name='theme-color']`)

            let map, geocoder, direction

            const day       = inject('day')
            const mobile    = inject('mobile')
            const baseurl   = inject('baseurl')
            const pusher    = inject('pusher')

            const instance  = getCurrentInstance()

            const router    = useRouter()
            const store     = useStore()

            const state     = reactive({
                layout: {
                    dark: false
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
                        admin: null,
                        messages: null
                    }
                },

                notification: {
                    type: '',
                    modal: false
                },

                map: {
                    place: 'Lokasi Belum Diketahui Untuk Sekarang.',
                    distance: null
                }
            })

            const schemaChat = object({
                pesan: string().required()
            })

            watch(() => state.layout.dark, (dark) => {
                localStorage.setItem('theme', dark ? 'dark' : 'light')
                appBarColor.setAttribute('content', dark ? '#1E293B' : '#3B82F6')

                if (dark) {
                    elementHtml.add('dark')
                    StatusBar.setBackgroundColor({ color: '#1E293B' })

                    map.setStyle('mapbox://styles/ti18husni0016/ckyjmin7o3r1x14pai0swit5o')
                } else {
                    elementHtml.remove('dark')
                    StatusBar.setBackgroundColor({ color: '#3B82F6' })

                    map.setStyle('mapbox://styles/mapbox/light-v10')
                }
            })

            watch(() => store.getters['order/orderStatus'], () => {
                setTimeout(() => map.resize(), 500)
            })

            Keyboard.addListener('keyboardDidShow', () => {
                setTimeout(() => map.resize(), 500)
            })

            Keyboard.addListener('keyboardDidHide', () => {
                setTimeout(() => map.resize(), 500)
            })

            const showChatDialog = () => {
                state.chat.modal     = ! state.chat.modal
                state.chat.newLength = 0

                if (state.chat.search.user.length <= 0) {
                    axios.get('/api/user/chat/user').then(({ data }) => {
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
                axios.get('/api/user/chat/' + id).then(({ data }) => {
                    state.chat.conversation = {
                        active: true,
                        admin: data.results.user,
                        messages: data.results.messages
                    }
                })
            }

            const sendMessage = (values, resetForm) => {
                axios.post('/api/user/chat', {
                    ...values, id_admin: state.chat.conversation.admin.id
                }).then(({ data }) => {
                    let getUser = state.chat.messages.findIndex(v => v.id_admin == state.chat.conversation.admin.id)

                    let payload = {
                        pesan: values.pesan,
                        pengirim: 'user',
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

                store.dispatch('buyer/savePayment', {
                    asset: {
                        saldo: 0,
                        kupon: 0
                    },
                    payment: {
                        id: null,
                        kode_pembayaran: null,
                        total_tx: 0,
                        status_bayar: 'belum'
                    }
                })

                GoogleAuth.signOut()
                FacebookLogin.logout()

                router.push({ name: 'auth.login' })
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

                    appBarColor.setAttribute('content', '#1E293B')
                    StatusBar.setBackgroundColor({ color: '#1E293B' })

                    state.layout.dark = true
                } else if (localStorage.getItem('theme') == 'dark') {
                    elementHtml.add('dark')

                    appBarColor.setAttribute('content', '#1E293B')
                    StatusBar.setBackgroundColor({ color: '#1E293B' })

                    state.layout.dark = true
                }

                let buyer = [], courier = []
                let buyerMarker

                let bounds
                let boundsPadding = {
                    top: 100,
                    bottom: 100,
                    left: mobile ? 100 : 200,
                    right: mobile ? 100 : 300
                }

                mapboxgl.accessToken = 'pk.eyJ1IjoidGkxOGh1c25pMDAxNiIsImEiOiJja3lqamJ3OGowOXpvMm9vMHJkaHdwZ3BrIn0.114PDt0ybnue0WY9HTW8Xw'

                map = new mapboxgl.Map({
                    container: 'map',
                    zoom: 16,
                    center: [109.6236733, -7.0299928],
                    maxBounds: [
                        [109.474847, -7.245632],
                        [109.794124, -6.837189]
                    ],
                    style: state.layout.dark ? 'mapbox://styles/ti18husni0016/ckyjmin7o3r1x14pai0swit5o' : 'mapbox://styles/mapbox/light-v10',
                    cooperativeGestures: mobile
                })

                instance.appContext.app._context.config.globalProperties.$map = map

                geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl,
                    limit: 1,
                    language: 'id',
                    countries: 'id',
                    marker: false,
                    reverseGeocode: true,
                    types: 'region,district,postcode,place,locality,neighborhood,address,poi'
                })

                direction = new MapboxDirections({
                    accessToken: mapboxgl.accessToken,
                    unit: 'metric',
                    profile: 'mapbox/driving-traffic',
                    alternatives: true,
                    flyTo: false,
                    interactive: false,
                    controls: {
                        inputs: false,
                        instructions: false
                    }
                })

                geocoder.onAdd(map)
                map.addControl(direction)

                axios.get('/api/user/chat').then(({ data }) => {
                    state.chat.messages = data.results
                })

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

                if (store.getters['buyer/payment'].id == null) {
                    axios.get('/api/user/payment').then(({ data }) => {
                        store.dispatch('buyer/savePayment', {
                            asset: data.results.asset ?? store.getters['buyer/asset'],
                            payment: data.results.payment
                        })

                        if (data.results.payment.status_order == 'aktif') {
                            store.dispatch('order/eventOrder', {
                                orderStatus: true,
                                deliveryStatus: data.results.payment.status_kurir
                            })

                            store.dispatch('order/saveCourierActive', {
                                id: data.results.payment.id_admin,
                                cost: data.results.payment.jumlah_fee
                            })
                        }
                    })
                }

                Geolocation.watchPosition({
                    timeout: 15000,
                    maximumAge: 15000,
                    enableHighAccuracy: true
                }, (position) => {
                    let buyerPosition = [position.coords.longitude, position.coords.latitude]

                    buyer.forEach(value => value?.remove())

                    buyerMarker = new mapboxgl.Marker({ color: '#f43f5e' })
                                            .setLngLat(buyerPosition)
                                            .addTo(map)

                    if (buyer.length == 0 || courier.length == 0) {
                        setTimeout(() => map.flyTo({
                            zoom: 16,
                            center: buyerPosition
                        }), 1000)

                        if (! mobile) map.easeTo({
                            padding: { right: 400 },
                            duration: 1000
                        })
                    }

                    buyer.length = 0
                    buyer.push(buyerMarker)

                    buyerMarker.getElement().addEventListener('click', () => {
                        map.flyTo({
                            zoom: 16,
                            center: buyerPosition
                        })

                        if (! mobile) map.easeTo({
                            padding: { right: 400 },
                            duration: 1000
                        })
                    })

                    geocoder.query(position.coords.latitude + "," + position.coords.longitude)
                    geocoder.on('result', (e) => state.map.place = e.result.place_name)

                    store.dispatch('order/saveOrderLocation', {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        alamat_lengkap: state.map.place
                    })

                    if (store.getters['order/orderStatus']) {
                        axios.post('/api/user/tracking/update', {
                            status: true,
                            location: store.getters['order/location']
                        })
                    }
                })

                channel.subscribe('product').bind('App\\Events\\UpdateProduct', ({ products }) => {
                    store.dispatch('product/saveDataProduct', { products })
                    
                    store.getters['cart/items'].forEach((item, index) => {
                        let status  = store.getters['order/orderStatus']
                        let product = products.find(v => v.id == item.id)

                        if (product.status == '1') {
                            store.dispatch('cart/updateCart', {
                                index, qty: (
                                    product?.stok < item.qty ? (status ? item.qty : product?.stok) : item.qty
                                )
                            })
                        } else {
                            if (! status) store.dispatch('cart/removeCart', { index })
                        }
                    })
                })

                channel.subscribe('courier').bind('App\\Events\\CourierLocation', ({ user, vehicle, location }) => {
                    let getIndexCourier = courier.findIndex(v => v.id == user.id)

                    if (location != null) {
                        bounds = new mapboxgl.LngLatBounds()

                        let buyerPosition   = [
                            store.getters['order/location'].longitude,
                            store.getters['order/location'].latitude
                        ]
                        let courierPosition = [ location.longitude, location.latitude ]

                        courier[getIndexCourier]?.marker.remove()

                        let courierMarker = new mapboxgl.Marker({ color: '#3b82f6' })
                                                        .setLngLat(courierPosition)
                                                        .addTo(map)

                        courierMarker.getElement().addEventListener('click', () => {
                            map.flyTo({
                                zoom: 16,
                                center: courierPosition
                            })

                            if (! mobile) map.easeTo({
                                padding: { right: 400 },
                                duration: 1000
                            })
                        })

                        let costFormula = Math.ceil(
                            parseInt(
                                parseFloat(turf.distance(buyerPosition, courierPosition, { units: 'kilometers' })) * 250
                            )
                        )

                        let courierCost = costFormula <= 1000 ? 1000 : costFormula

                        let dataCourier = {
                            id: user.id, user, vehicle,
                            cost: courierCost,
                            marker: courierMarker
                        }

                        getIndexCourier > -1 ? (courier[getIndexCourier] = dataCourier) : courier.push(dataCourier)

                        store.dispatch('courier/saveDataCourier', {
                            courier: courier
                        })

                        if (
                            store.getters['order/deliveryStatus'] == 'process' ||
                            store.getters['order/deliveryStatus'] == 'delivered'
                        ) {
                            if (store.getters['order/courier'].id == user.id) {
                                let getIndexCourierActive = courier.findIndex(
                                    v => v.id == store.getters['order/courier'].id
                                )

                                let activeCourierLocation = [
                                    courier[getIndexCourierActive].marker._lngLat.lng,
                                    courier[getIndexCourierActive].marker._lngLat.lat
                                ]

                                bounds.extend(buyerPosition)
                                bounds.extend(activeCourierLocation)

                                direction.setOrigin(activeCourierLocation)
                                direction.setDestination(buyerPosition)

                                store.dispatch('courier/saveDataTaker', {
                                    user, vehicle, location,
                                    distance: turf.distance(buyerPosition, activeCourierLocation, {
                                        units: 'kilometers'
                                    })
                                })
                            }
                        } else {
                            bounds.extend(buyerPosition)

                            courier.forEach(value => {
                                bounds.extend([ value.marker._lngLat.lng, value.marker._lngLat.lat ])
                            })
                        }

                        map.fitBounds(bounds, {
                            padding: boundsPadding
                        })

                        if (store.getters['order/orderStatus'] == 'offline') {
                            store.dispatch('order/eventOrder', {
                                orderStatus: store.getters['order/orderStatus'],
                                deliveryStatus: 'ready'
                            })
                        }
                    } else {
                        courier[getIndexCourier].marker?.remove()
                        courier.splice(getIndexCourier, 1)
                    }
                })

                channel.subscribe('private-topup.status.' + store.getters['auth/user'].id)
                    .bind('App\\Events\\CreateTopUpStatus', ({ amount }) => {
                        Haptics.vibrate()

                        if (device == 'android') LocalNotifications.schedule({
                            notifications: [
                                {
                                    id: 6,
                                    title: 'TopUp Saldo Berhasil',
                                    body: 'Pengisian sebesar Rp. ' + (parseInt(amount) - store.getters['buyer/asset'].saldo).toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") + ' berhasil, Silahkan cek saldo aplikasi',
                                    actionTypeId: 'actionNotification'
                                }
                            ]
                        })

                        state.notification = {
                            type: 'topup-success',
                            modal: true
                        }

                        store.dispatch('buyer/savePayment', {
                            asset: {
                                ...store.getters['buyer/asset'],
                                saldo: amount
                            },
                            payment: store.getters['buyer/payment']
                        })
                    })

                channel.subscribe('private-chatBuyer.' + store.getters['auth/user'].id)
                    .bind('App\\Events\\BuyerMessage', ({ from, message }) => {
                        let getUser = state.chat.messages.findIndex(v => v.id_admin == from.id)

                        let payload = {
                            pesan: message,
                            pengirim: 'admin',
                            created_at: new Date()
                        }

                        state.chat.newLength += 1

                        if (getUser >= 0) {
                            state.chat.messages[getUser] = {
                                ...state.chat.messages[getUser], ...payload
                            }
                        } else {
                            state.chat.messages.push({
                                ...from, ...payload
                            })
                        }

                        if (state.chat.conversation.active && state.chat.conversation.admin.id == from.id) {
                            state.chat.conversation.messages.push(payload)
                        }

                        if (device == 'android') {
                            Haptics.vibrate({ duration: 150 })

                            LocalNotifications.schedule({
                                notifications: [
                                    {
                                        id: 0,
                                        title: 'Pesan admin dari ' + from.nama_depan,
                                        body: message.substring(0, 25),
                                        actionTypeId: 'actionNotification'
                                    }
                                ]
                            })
                        }
                    })

                channel.subscribe('private-order.status.' + store.getters['auth/user'].id)
                    .bind('App\\Events\\CreateOrderStatus', ({ courierId, courierCost, orderStatus, courierStatus }) => {
                        let getIndexCourier = courier.findIndex(v => v.id == courierId)

                        Haptics.vibrate({ duration: 150 })

                        switch (courierStatus) {
                            case 'process':
                                state.notification.type = 'courier-process'

                                direction.setOrigin([
                                    courier[getIndexCourier].marker._lngLat.lng,
                                    courier[getIndexCourier].marker._lngLat.lat
                                ])

                                direction.setDestination([
                                    store.getters['order/location'].longitude,
                                    store.getters['order/location'].latitude
                                ])

                                store.dispatch('order/saveCourierActive', {
                                    id: courierId,
                                    cost: courierCost
                                })

                                if (device == 'android') {
                                    LocalNotifications.schedule({
                                        notifications: [
                                            {
                                                id: 1,
                                                title: 'Pesanan Dikonfirmasi',
                                                body: 'Kurir sedang menuju ke tempat anda',
                                                actionTypeId: 'actionNotification'
                                            }
                                        ]
                                    })
                                }
                                break;

                            case 'canceled':
                                state.notification.type = 'courier-canceled'

                                direction.removeRoutes()

                                if (device == 'android') {
                                    LocalNotifications.schedule({
                                        notifications: [
                                            {
                                                id: 2,
                                                title: 'Pesanan Gagal',
                                                body: 'Pesanan anda gagal, silahkan hubungi kurir',
                                                actionTypeId: 'actionNotification'
                                            }
                                        ]
                                    })
                                }
                                break;

                            case 'delivered':
                                state.notification.type = 'courier-delivered'

                                direction.removeRoutes()

                                store.dispatch('order/saveCourierActive', {
                                    id: courierId,
                                    cost: courierCost
                                })

                                if (device == 'android') {
                                    LocalNotifications.schedule({
                                        notifications: [
                                            {
                                                id: 3,
                                                title: 'Kurir Sudah Sampai Tujuan',
                                                body: 'Harap membawa uang pas atau bisa menggunakan ewallet',
                                                actionTypeId: 'actionNotification'
                                            }
                                        ]
                                    })
                                }
                                break;
                        
                            default:
                                break;
                        }

                        state.notification.modal = true

                        store.dispatch('order/eventOrder', {
                            orderStatus, deliveryStatus: courierStatus
                        })
                    })

                channel.subscribe('private-payment.status.' + store.getters['auth/user'].id)
                    .bind('App\\Events\\CreatePaymentStatus', ({ asset, paymentStatus }) => {
                        let deliveryStatus

                        Haptics.vibrate({ duration: 150 })

                        switch (paymentStatus) {
                            case 'lunas':
                                deliveryStatus = 'paid off'
                                state.notification.type = 'payment-success'

                                store.dispatch('cart/resetCart')

                                store.dispatch('buyer/savePayment', {
                                    asset, payment: {
                                        ...store.getters['buyer/payment'],
                                        total_tx: (parseInt(store.getters['buyer/payment'].total_tx) + 1)
                                    }
                                })

                                if (device == 'android') {
                                    LocalNotifications.schedule({
                                        notifications: [
                                            {
                                                id: 4,
                                                title: 'Pembayaran Lunas',
                                                body: 'Terima kasih sudah mengorder produk dari kami',
                                                actionTypeId: 'actionNotification'
                                            }
                                        ]
                                    })
                                }

                                router.push({ name: 'dashboard.history' })
                                break;

                            case 'gagal':
                                deliveryStatus = 'fail'
                                state.notification.type = 'payment-failed'

                                if (device == 'android') {
                                    LocalNotifications.schedule({
                                        notifications: [
                                            {
                                                id: 5,
                                                title: 'Maaf, Pembayaran Gagal',
                                                body: 'Jika anda sudah membayar, silahkan hubungi kurir',
                                                actionTypeId: 'actionNotification'
                                            }
                                        ]
                                    })
                                }
                                break;
                        
                            default:
                                break;
                        }

                        state.notification.modal = true

                        store.dispatch('order/eventOrder', {
                            orderStatus: false, deliveryStatus
                        })

                        axios.get('/api/user/payment').then(({ data }) => {
                            store.dispatch('buyer/savePayment', {
                                asset: data.results.asset ?? store.getters['buyer/asset'],
                                payment: data.results.payment
                            })
                        })
                    })
            })

            return {
                day, mobile, baseurl,
                store, state,
                schemaChat,
                showChatDialog, filterChatUser, connectMessage, sendMessage,
                logout
            }
        }
    }
</script>
