<x-guest-layout>

    @if (Route::has('login'))
    <div class="row">
        <div class="container-xl mb-4 px-3">
            <div class="row text-center align-items-center">
                <div class="col-auto">
                    <ul class="list-inline list-inline-dots mb-0">
                        @auth
                            <li class="list-inline-item"><a href="{{ url('/dashboard') }}" class="link-secondary">Dashboard</a></li>
                        @else
                            <li class="list-inline-item"><a href="{{ route('login') }}" class="link-secondary">Login</a></li>
                            @if (Route::has('register'))
                            <li class="list-inline-item"><a href="{{ route('register') }}" class="link-secondary">Register</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-stamp">
                    <div class="card-stamp-icon bg-danger">
                        <svg viewBox="-10 0 86 63" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="h-16 w-auto">
                            <path
                                d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                fill="#ffffff" />
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Laravel</h3>
                    <p class="text-secondary">Your application back-end is powered by Laravel, the most popular PHP framework. Use any of the many features it provides or countless packages the community has built.</p>
                    <p class="pt-3">
                        <a target="_blank" href="https://laravel.com/docs" class="btn btn-link-secondary">
                            Docs
                        </a>
                        <a target="_blank" href="https://laracasts.com" class="btn btn-link-secondary">
                            Video Tutorials
                        </a>
                        <a target="_blank" href="https://github.com/laravel/framework" class="btn btn-link-secondary">
                            Github
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-stamp">
                    <div class="card-stamp-icon bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68">
                            <path
                                d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                                fill="#0054a6" />
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Tabler</h3>
                    <p class="text-secondary">Your application UI is powered by Tabler, one of the most popular Bootstrap HTML templates. Copy-paste any of the 200+ components and they will "<i>just work</i>".</p>
                    <p class="pt-3">
                        <a target="_blank" href="https://tabler.io" class="btn btn-link-secondary">
                            Website
                        </a>
                        <a target="_blank" href="https://tabler.io/preview" class="btn btn-link-secondary">
                            Preview
                        </a>
                        <a target="_blank" href="https://tabler.io/docs" class="btn btn-link-secondary">
                            Docs
                        </a>
                        <a target="_blank" href="https://github.com/tabler/tabler" class="btn btn-link-secondary">
                            Github
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-stamp">
                    <div class="card-stamp-icon bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128">
                            <path style="fill-rule:evenodd;fill:#fb70a9;fill-opacity:1"
                                d="M108.566 83.547c-1.937 2.926-3.406 6.527-7.34 6.527-6.624 0-6.98-10.203-13.609-10.203-6.625 0-6.265 10.203-12.887 10.203-6.625 0-6.98-10.203-13.609-10.203-6.625 0-6.266 10.203-12.887 10.203-6.625 0-6.98-10.203-13.605-10.203-6.629 0-6.27 10.203-12.89 10.203-2.083 0-3.544-1.008-4.778-2.39-4.738-8.239-7.465-17.895-7.465-28.22 0-30.222 23.367-54.722 52.191-54.722 28.825 0 52.192 24.5 52.192 54.723 0 8.64-1.91 16.816-5.313 24.082Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#4e56a6;fill-opacity:1"
                                d="M40.844 78.145v22.668c0 4.066-3.301 7.363-7.371 7.363a7.365 7.365 0 0 1-7.371-7.364V73.45c1.375-2.523 2.945-4.707 5.78-4.707 4.61 0 6.223 5.79 8.962 9.403Zm27.843 1.183v35.844a8.185 8.185 0 0 1-8.187 8.183c-4.523 0-8.191-3.664-8.191-8.183v-40.57c1.543-2.973 3.132-5.86 6.39-5.86 5.16 0 6.563 7.242 9.989 10.586Zm26.211-.66v26.023c0 4.067-3.3 7.364-7.37 7.364-4.071 0-7.372-3.297-7.372-7.364V72.707c1.281-2.195 2.809-3.965 5.364-3.965 4.84 0 6.375 6.38 9.378 9.926Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#000;fill-opacity:.298039"
                                d="M40.844 85.094c-1.309-1.602-2.856-2.79-5.094-2.79-5.316 0-6.293 6.696-9.648 9.712V63.145a7.365 7.365 0 0 1 7.37-7.364c4.071 0 7.372 3.297 7.372 7.364Zm27.843.515c-1.394-1.855-3.023-3.304-5.496-3.304-5.914 0-6.457 8.285-10.882 10.578v-12.77c0-4.52 3.668-8.183 8.191-8.183a8.185 8.185 0 0 1 8.188 8.183Zm26.211-1.433c-1.136-1.117-2.48-1.871-4.265-1.871-5.73 0-6.418 7.777-10.477 10.343V66.734a7.371 7.371 0 0 1 14.742 0Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#fb70a9;fill-opacity:1"
                                d="M108.566 83.547c-1.937 2.926-3.406 6.527-7.34 6.527-6.624 0-6.98-10.203-13.609-10.203-6.625 0-6.265 10.203-12.887 10.203-6.625 0-6.98-10.203-13.609-10.203-6.625 0-6.266 10.203-12.887 10.203-6.625 0-6.98-10.203-13.605-10.203-6.629 0-6.27 10.203-12.89 10.203-2.083 0-3.544-1.008-4.778-2.39-4.738-8.239-7.465-17.895-7.465-28.22 0-30.222 23.367-54.722 52.191-54.722 28.825 0 52.192 24.5 52.192 54.723 0 8.64-1.91 16.816-5.313 24.082Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#e24ca6;fill-opacity:1"
                                d="M97.273 88.984c13.676-20.332 14.028-42.879 1.059-67.652 9.613 9.844 15.547 23.348 15.547 38.25 0 8.61-1.98 16.75-5.508 23.992-2.004 2.91-3.531 6.5-7.61 6.5a5.947 5.947 0 0 1-3.488-1.09Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#fff;fill-opacity:1"
                                d="M58.89 73.117c18.15 0 25.79-10.52 25.79-25.46 0-14.942-11.547-28.692-25.79-28.692-14.245 0-25.792 13.75-25.792 28.691 0 14.942 7.64 25.461 25.793 25.461Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#030776;fill-opacity:1"
                                d="M61.625 37.836c0 5.89-4.332 10.668-9.672 10.668-5.344 0-9.672-4.777-9.672-10.668 0-5.89 4.328-10.668 9.672-10.668 5.34 0 9.672 4.777 9.672 10.668Zm0 0" />
                            <path style="fill-rule:evenodd;fill:#fff;fill-opacity:1"
                                d="M55.176 35.375c0 2.719-2.164 4.922-4.836 4.922s-4.836-2.203-4.836-4.922 2.164-4.922 4.836-4.922 4.836 2.203 4.836 4.922Zm0 0" />
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Livewire</h3>
                    <p class="text-secondary"><i>Optional.</i> If you like Blade templates, you will probably love Laravel Livewire. It will help you make some Blade components "live" without the hassle of writing your own AJAX or JS.</p>
                    <p class="pt-3">
                        <a target="_blank" href="https://livewire.laravel.com/" class="btn btn-link-secondary">
                            Docs
                        </a>
                        <a target="_blank" href="https://livewire.laravel.com/screencasts" class="btn btn-link-secondary">
                            Video Tutorials
                        </a>
                        <a target="_blank" href="https://github.com/livewire/livewire" class="btn btn-link-secondary">
                            Github
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-stamp">
                    <div class="card-stamp-icon bg-transparent">
                        <svg width="128" height="128" viewBox="0 0 318 188" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M38.1251 0H266.487C287.524 0 304.613 17.0888 304.613 38.1251V266.487C304.613 287.524 287.524 304.613 266.487 304.613H38.1251C17.0888 304.613 0 287.524 0 266.487V38.1251C0 17.0888 17.0888 0 38.1251 0Z"
                                fill="url(#paint0_radial_21_19)"></path>
                            <path
                                d="M143.644 60.7133V174.11C143.644 175.611 142.817 176.978 141.484 177.686L102.448 198.335C99.7493 199.752 96.5104 197.812 96.5104 194.758V86.6924C96.5104 83.2341 98.3492 80.0289 101.352 78.2914L137.554 57.2214C140.253 55.6525 143.627 57.5925 143.627 60.7133H143.644ZM107.307 214.867L149.497 239.226C151.218 240.222 153.361 240.222 155.081 239.226L194.455 216.486C197.188 214.901 197.137 210.936 194.353 209.435L152.433 186.813C150.796 185.936 148.823 185.919 147.169 186.796L107.459 207.798C104.641 209.283 104.574 213.281 107.324 214.867H107.307ZM208.068 198.419V149.109C208.068 146.933 206.904 144.926 205.032 143.846L161.171 118.542C158.472 116.99 155.115 118.93 155.115 122.051V173.014C155.115 175.257 156.346 177.298 158.303 178.361L202.113 201.995C204.813 203.446 208.068 201.489 208.068 198.436V198.419Z"
                                fill="white"></path>
                            <defs>
                                <radialGradient id="paint0_radial_21_19" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse"
                                    gradientTransform="translate(-1.34955 -1.34955) scale(435.419)">
                                    <stop stop-color="#8D7CEF"></stop>
                                    <stop offset="0.04" stop-color="#8371EF"></stop>
                                    <stop offset="0.09" stop-color="#7D6AEF"></stop>
                                    <stop offset="0.24" stop-color="#7C69EF"></stop>
                                    <stop offset="0.4" stop-color="#7A63E4"></stop>
                                    <stop offset="0.66" stop-color="#7453C9"></stop>
                                    <stop offset="0.99" stop-color="#6C399C"></stop>
                                    <stop offset="1" stop-color="#6C399C"></stop>
                                </radialGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Backpack</h3>
                    <p class="text-secondary"><i>Optional.</i> If you like this starter kit, you'll probably love our main product, Backpack. It will help you quickly create an admin panel for your app, then easily maintain it over the years.</p>
                    <p class="pt-3">
                        <a target="_blank" href="https://backpackforlaravel.com/" class="btn btn-link-secondary">
                            Website
                        </a>
                        <a target="_blank" href="https://backpackforlaravel.com/docs" class="btn btn-link-secondary">
                            Docs
                        </a>
                        <a target="_blank" href="https://backpackforlaravel.com/docs/getting-started-videos" class="btn btn-link-secondary">
                            Video Tutorials
                        </a>
                        <a target="_blank" href="https://github.com/laravel-backpack/crud" class="btn btn-link-secondary">
                            Github
                        </a>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <footer class="footer footer-transparent d-print-none">
        <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
                <div class="col-lg-auto ms-lg-auto">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>
    </footer>

</x-guest-layout>
