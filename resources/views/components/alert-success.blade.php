@props(['message'])

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-24 right-5 z-50 w-full max-w-[400px]">
    <div class="relative flex w-full items-center rounded-lg border border-green-light-4 bg-white p-4 shadow-sm dark:border-green-800 dark:bg-gray-800">
        <div class="mr-4 flex h-[50px] w-full max-w-[50px] items-center justify-center rounded-[5px] bg-green-500">
             <svg width="24" height="24" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1088_26002)">
                    <path d="M24.5969 18.7531H9.40312C9.03125 18.7531 8.65937 18.9125 8.44687 19.2313C8.23437 19.55 8.12812 19.9219 8.23437 20.2938C9.35 24.225 12.9625 26.9875 17 26.9875C21.1437 26.9875 24.65 24.3313 25.7656 20.2938C25.8719 19.9219 25.8187 19.55 25.5531 19.2313C25.3406 18.9125 24.9687 18.7531 24.5969 18.7531ZM17 24.5438C14.5562 24.5438 12.3781 23.2156 11.1562 21.1438H22.8437C21.675 23.2156 19.4969 24.5438 17 24.5438Z" fill="white" />
                    <path d="M17 0.425003C7.8625 0.425003 0.425003 7.8625 0.425003 17C0.425003 26.1375 7.8625 33.6281 17.0531 33.6281C26.2438 33.6281 33.6813 26.1906 33.6813 17C33.6813 7.80938 26.1375 0.425003 17 0.425003ZM17 31.2375C9.1375 31.2375 2.7625 24.8625 2.7625 17C2.7625 9.1375 9.19063 2.81563 17 2.81563C24.8094 2.81563 31.2375 9.19063 31.2375 17.0531C31.2375 24.9156 24.8625 31.2375 17 31.2375Z" fill="white" />
                    <path d="M10.625 14.2375C11.7986 14.2375 12.75 13.2861 12.75 12.1125C12.75 10.9389 11.7986 9.9875 10.625 9.9875C9.45139 9.9875 8.5 10.9389 8.5 12.1125C8.5 13.2861 9.45139 14.2375 10.625 14.2375Z" fill="white" />
                    <path d="M23.375 14.2375C24.5486 14.2375 25.5 13.2861 25.5 12.1125C25.5 10.9389 24.5486 9.9875 23.375 9.9875C22.2014 9.9875 21.25 10.9389 21.25 12.1125C21.25 13.2861 22.2014 14.2375 23.375 14.2375Z" fill="white" />
                </g>
                <defs>
                    <clipPath id="clip0_1088_26002">
                        <rect width="34" height="34" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>

        <div class="flex w-full items-center justify-between">
            <div>
                <h6 class="mb-0.5 text-base font-semibold text-black dark:text-white">
                    Success
                </h6>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                   {{ $message }}
                </p>
            </div>

            <button @click="show = false" class="text-gray-500 hover:text-green-600 dark:text-gray-400">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                    <g clip-path="url(#clip0_1088_26057)">
                        <path d="M8.79999 7.99999L14.9 1.89999C15.125 1.67499 15.125 1.32499 14.9 1.09999C14.675 0.874994 14.325 0.874994 14.1 1.09999L7.99999 7.19999L1.89999 1.09999C1.67499 0.874994 1.32499 0.874994 1.09999 1.09999C0.874994 1.32499 0.874994 1.67499 1.09999 1.89999L7.19999 7.99999L1.09999 14.1C0.874994 14.325 0.874994 14.675 1.09999 14.9C1.19999 15 1.34999 15.075 1.49999 15.075C1.64999 15.075 1.79999 15.025 1.89999 14.9L7.99999 8.79999L14.1 14.9C14.2 15 14.35 15.075 14.5 15.075C14.65 15.075 14.8 15.025 14.9 14.9C15.125 14.675 15.125 14.325 14.9 14.1L8.79999 7.99999Z" />
                    </g>
                    <defs>
                        <clipPath id="clip0_1088_26057">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </button>
        </div>
    </div>
</div>
