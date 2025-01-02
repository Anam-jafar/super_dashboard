        <div id="hs-overlay-switcher" class="hs-overlay hidden ti-offcanvas ti-offcanvas-right" tabindex="-1">
            <div class="ti-offcanvas-header border-defaultborder dark:border-defaultborder/10">
                <h5 class="ti-offcanvas-title">
                    Switcher
                </h5>
                <button type="button"
                    class="ti-btn flex-shrink-0 p-0 transition-none text-defaulttextcolor dark:text-defaulttextcolor/70 hover:text-gray-700 focus:ring-gray-400 focus:ring-offset-white  dark:hover:text-white/80 dark:focus:ring-white/10 dark:focus:ring-offset-white/10"
                    data-hs-overlay="#hs-overlay-switcher">
                    <span class="sr-only">Close modal</span>
                    <i class="ri-close-circle-line leading-none text-lg"></i>
                </button>
            </div>
            <div class="ti-offcanvas-body !p-0" id="switcher-body">
                <div>
                    <div>
                        <p class="switcher-style-head">Theme Color Mode:</p>
                        <div class="grid grid-cols-3 gap-6 switcher-style">
                            <div class="flex">
                                <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-light-theme"
                                    checked>
                                <label for="switcher-light-theme"
                                    class="text-xs text-defaulttextcolor dark:text-defaulttextcolor/70 font-semibold ms-2 ">Light</label>
                            </div>
                            <div class="flex">
                                <input type="radio" name="theme-style" class="ti-form-radio" id="switcher-dark-theme">
                                <label for="switcher-dark-theme"
                                    class="text-xs text-defaulttextcolor dark:text-defaulttextcolor/70 font-semibold ms-2 ">Dark</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="switcher-style-head">Directions:</p>
                        <div class="grid grid-cols-3 gap-6 switcher-style">
                            <div class="flex">
                                <input type="radio" name="direction" class="ti-form-radio" id="switcher-ltr" checked>
                                <label for="switcher-ltr"
                                    class="text-xs font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2 ">LTR</label>
                            </div>
                            <div class="flex">
                                <input type="radio" name="direction" class="ti-form-radio" id="switcher-rtl">
                                <label for="switcher-rtl"
                                    class="text-xs font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70 ms-2 ">RTL</label>
                            </div>
                        </div>
                    </div>
                    <div class="theme-colors">
                        <p class="switcher-style-head">Theme Primary:</p>
                        <div class="flex switcher-style space-x-3 rtl:space-x-reverse">
                            <div class="ti-form-radio switch-select">
                                <input class="ti-form-radio color-input color-primary-1" type="radio" name="theme-primary"
                                    id="switcher-primary">
                            </div>
                            <div class="ti-form-radio switch-select">
                                <input class="ti-form-radio color-input color-primary-2" type="radio" name="theme-primary"
                                    id="switcher-primary1">
                            </div>
                            <div class="ti-form-radio switch-select">
                                <input class="ti-form-radio color-input color-primary-3" type="radio" name="theme-primary"
                                    id="switcher-primary2">
                            </div>
                            <div class="ti-form-radio switch-select">
                                <input class="ti-form-radio color-input color-primary-4" type="radio" name="theme-primary"
                                    id="switcher-primary3">
                            </div>
                            <div class="ti-form-radio switch-select">
                                <input class="ti-form-radio color-input color-primary-5" type="radio" name="theme-primary"
                                    id="switcher-primary4">
                            </div>
                            <div class="ti-form-radio switch-select ps-0 mt-1 color-primary-light">
                                <div class="theme-container-primary"></div>
                                <div class="pickr-container-primary"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ti-offcanvas-footer sm:flex justify-between">
                <a href="javascript:void(0);" id="reset-all" class="w-full ti-btn ti-btn-danger m-1">Reset</a>
            </div>
        </div>