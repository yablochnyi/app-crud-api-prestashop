<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script>
    const ANIMATION_DURATION = 300;

    const SIDEBAR_EL = document.getElementById("sidebar");

    const SUB_MENU_ELS = document.querySelectorAll(
        ".menu > ul > .menu-item.sub-menu"
    );

    const FIRST_SUB_MENUS_BTN = document.querySelectorAll(
        ".menu > ul > .menu-item.sub-menu > a"
    );

    const INNER_SUB_MENUS_BTN = document.querySelectorAll(
        ".menu > ul > .menu-item.sub-menu .menu-item.sub-menu > a"
    );

    class PopperObject {
        instance = null;
        reference = null;
        popperTarget = null;

        constructor(reference, popperTarget) {
            this.init(reference, popperTarget);
        }

        init(reference, popperTarget) {
            this.reference = reference;
            this.popperTarget = popperTarget;
            this.instance = Popper.createPopper(this.reference, this.popperTarget, {
                placement: "right",
                strategy: "fixed",
                resize: true,
                modifiers: [
                    {
                        name: "computeStyles",
                        options: {
                            adaptive: false
                        }
                    },
                    {
                        name: "flip",
                        options: {
                            fallbackPlacements: ["left", "right"]
                        }
                    }
                ]
            });

            document.addEventListener(
                "click",
                (e) => this.clicker(e, this.popperTarget, this.reference),
                false
            );

            const ro = new ResizeObserver(() => {
                this.instance.update();
            });

            ro.observe(this.popperTarget);
            ro.observe(this.reference);
        }

        clicker(event, popperTarget, reference) {
            if (
                SIDEBAR_EL.classList.contains("collapsed") &&
                !popperTarget.contains(event.target) &&
                !reference.contains(event.target)
            ) {
                this.hide();
            }
        }

        hide() {
            this.instance.state.elements.popper.style.visibility = "hidden";
        }
    }

    class Poppers {
        subMenuPoppers = [];

        constructor() {
            this.init();
        }

        init() {
            SUB_MENU_ELS.forEach((element) => {
                this.subMenuPoppers.push(
                    new PopperObject(element, element.lastElementChild)
                );
                this.closePoppers();
            });
        }

        togglePopper(target) {
            if (window.getComputedStyle(target).visibility === "hidden")
                target.style.visibility = "visible";
            else target.style.visibility = "hidden";
        }

        updatePoppers() {
            this.subMenuPoppers.forEach((element) => {
                element.instance.state.elements.popper.style.display = "none";
                element.instance.update();
            });
        }

        closePoppers() {
            this.subMenuPoppers.forEach((element) => {
                element.hide();
            });
        }
    }

    const slideUp = (target, duration = ANIMATION_DURATION) => {
        const { parentElement } = target;
        parentElement.classList.remove("open");
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = `${duration}ms`;
        target.style.boxSizing = "border-box";
        target.style.height = `${target.offsetHeight}px`;
        target.offsetHeight;
        target.style.overflow = "hidden";
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        window.setTimeout(() => {
            target.style.display = "none";
            target.style.removeProperty("height");
            target.style.removeProperty("padding-top");
            target.style.removeProperty("padding-bottom");
            target.style.removeProperty("margin-top");
            target.style.removeProperty("margin-bottom");
            target.style.removeProperty("overflow");
            target.style.removeProperty("transition-duration");
            target.style.removeProperty("transition-property");
        }, duration);
    };
    const slideDown = (target, duration = ANIMATION_DURATION) => {
        const { parentElement } = target;
        parentElement.classList.add("open");
        target.style.removeProperty("display");
        let { display } = window.getComputedStyle(target);
        if (display === "none") display = "block";
        target.style.display = display;
        const height = target.offsetHeight;
        target.style.overflow = "hidden";
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        target.offsetHeight;
        target.style.boxSizing = "border-box";
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = `${duration}ms`;
        target.style.height = `${height}px`;
        target.style.removeProperty("padding-top");
        target.style.removeProperty("padding-bottom");
        target.style.removeProperty("margin-top");
        target.style.removeProperty("margin-bottom");
        window.setTimeout(() => {
            target.style.removeProperty("height");
            target.style.removeProperty("overflow");
            target.style.removeProperty("transition-duration");
            target.style.removeProperty("transition-property");
        }, duration);
    };

    const slideToggle = (target, duration = ANIMATION_DURATION) => {
        if (window.getComputedStyle(target).display === "none")
            return slideDown(target, duration);
        return slideUp(target, duration);
    };

    const PoppersInstance = new Poppers();

    /**
     * wait for the current animation to finish and update poppers position
     */
    const updatePoppersTimeout = () => {
        setTimeout(() => {
            PoppersInstance.updatePoppers();
        }, ANIMATION_DURATION);
    };

    /**
     * sidebar collapse handler
     */
    document.getElementById("btn-collapse").addEventListener("click", () => {
        SIDEBAR_EL.classList.toggle("collapsed");
        PoppersInstance.closePoppers();
        if (SIDEBAR_EL.classList.contains("collapsed"))
            FIRST_SUB_MENUS_BTN.forEach((element) => {
                element.parentElement.classList.remove("open");
            });

        updatePoppersTimeout();
    });

    /**
     * sidebar toggle handler (on break point )
     */
    document.getElementById("btn-toggle").addEventListener("click", () => {
        SIDEBAR_EL.classList.toggle("toggled");

        updatePoppersTimeout();
    });

    /**
     * toggle sidebar on overlay click
     */
    document.getElementById("overlay").addEventListener("click", () => {
        SIDEBAR_EL.classList.toggle("toggled");
    });

    const defaultOpenMenus = document.querySelectorAll(".menu-item.sub-menu.open");

    defaultOpenMenus.forEach((element) => {
        element.lastElementChild.style.display = "block";
    });

    /**
     * handle top level submenu click
     */
    FIRST_SUB_MENUS_BTN.forEach((element) => {
        element.addEventListener("click", () => {
            if (SIDEBAR_EL.classList.contains("collapsed"))
                PoppersInstance.togglePopper(element.nextElementSibling);
            else {
                const parentMenu = element.closest(".menu.open-current-submenu");
                if (parentMenu)
                    parentMenu
                        .querySelectorAll(":scope > ul > .menu-item.sub-menu > a")
                        .forEach(
                            (el) =>
                                window.getComputedStyle(el.nextElementSibling).display !==
                                "none" && slideUp(el.nextElementSibling)
                        );
                slideToggle(element.nextElementSibling);
            }
        });
    });

    /**
     * handle inner submenu click
     */
    INNER_SUB_MENUS_BTN.forEach((element) => {
        element.addEventListener("click", () => {
            slideToggle(element.nextElementSibling);
        });
    });

</script>
<div class="layout has-sidebar fixed-sidebar fixed-header">
    <aside id="sidebar" class="sidebar break-point-lg has-bg-image">
        <div class="image-wrapper">
            <img src="https://user-images.githubusercontent.com/25878302/144499035-2911184c-76d3-4611-86e7-bc4e8ff84ff5.jpg" alt="sidebar background" />
        </div>
        <div class="sidebar-layout">
            <div class="sidebar-header">
        <span style="
                text-transform: uppercase;
                font-size: 15px;
                letter-spacing: 3px;
                font-weight: bold;
              ">Pro Sidebar</span>
            </div>
            <div class="sidebar-content">
                <nav class="menu open-current-submenu">
                    <ul>
                        <li class="menu-item sub-menu">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-vip-diamond-fill"></i>
                </span>
                                <span class="menu-title">Components</span>
                                <span class="menu-suffix">&#x1F525;</span>
                            </a>
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Grid</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Layout</span>
                                        </a>
                                    </li>
                                    <li class="menu-item sub-menu">
                                        <a href="#">
                                            <span class="menu-title">Forms</span>
                                        </a>
                                        <div class="sub-menu-list">
                                            <ul>
                                                <li class="menu-item">
                                                    <a href="#">
                                                        <span class="menu-title">Input</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item">
                                                    <a href="#">
                                                        <span class="menu-title">Select</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item sub-menu">
                                                    <a href="#">
                                                        <span class="menu-title">More</span>
                                                    </a>
                                                    <div class="sub-menu-list">
                                                        <ul>
                                                            <li class="menu-item">
                                                                <a href="#">
                                                                    <span class="menu-title">CheckBox</span>
                                                                </a>
                                                            </li>
                                                            <li class="menu-item">
                                                                <a href="#">
                                                                    <span class="menu-title">Radio</span>
                                                                </a>
                                                            </li>
                                                            <li class="menu-item sub-menu">
                                                                <a href="#">
                                                                    <span class="menu-title">Want more ?</span>
                                                                    <span class="menu-suffix">&#x1F914;</span>
                                                                </a>
                                                                <div class="sub-menu-list">
                                                                    <ul>
                                                                        <li class="menu-item">
                                                                            <a href="#">
                                                                                <span class="menu-prefix">&#127881;</span>
                                                                                <span class="menu-title">You made it </span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item sub-menu">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-bar-chart-2-fill"></i>
                </span>
                                <span class="menu-title">Charts</span>
                            </a>
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Pie chart</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Line chart</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Bar chart</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item sub-menu">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-shopping-cart-fill"></i>
                </span>
                                <span class="menu-title">E-commerce</span>
                            </a>
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Products</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Orders</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">credit card</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item sub-menu">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-global-fill"></i>
                </span>
                                <span class="menu-title">Maps</span>
                            </a>
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Google maps</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Open street map</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item sub-menu">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-brush-3-fill"></i>
                </span>
                                <span class="menu-title">Theme</span>
                            </a>
                            <div class="sub-menu-list">
                                <ul>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Dark</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="#">
                                            <span class="menu-title">Light</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-book-2-fill"></i>
                </span>
                                <span class="menu-title">Documentation</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-calendar-fill"></i>
                </span>
                                <span class="menu-title">Calendar</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#">
                <span class="menu-icon">
                  <i class="ri-service-fill"></i>
                </span>
                                <span class="menu-title">Examples</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="sidebar-footer"><span>Sidebar footer</span></div>
        </div>
    </aside>
    <div id="overlay" class="overlay"></div>
    <div class="layout">
        <header class="header">
            <a id="btn-collapse" href="#">
                <i class="ri-menu-line ri-xl"></i>
            </a>
            <a id="btn-toggle" href="#" class="sidebar-toggler break-point-lg">
                <i class="ri-menu-line ri-xl"></i>
            </a>
        </header>
        <main class="content">
            <div>
                <h1>Pro Sidebar</h1>
                <p>
                    Responsive layout with advanced sidebar menu built with SCSS and vanilla Javascript
                </p>
                <p>
                    Full Code and documentation available on  <a href="https://github.com/azouaoui-med/pro-sidebar-template" target="_blank">Github</a>
                </p>
                <div>
                    <a href="https://github.com/azouaoui-med/pro-sidebar-template" target="_blank">
                        <img alt="GitHub stars" src="https://img.shields.io/github/stars/azouaoui-med/pro-sidebar-template?style=social" />
                    </a>
                    <a href="https://github.com/azouaoui-med/pro-sidebar-template" target="_blank">
                        <img alt="GitHub forks" src="https://img.shields.io/github/forks/azouaoui-med/pro-sidebar-template?style=social" />
                    </a>
                </div>
            </div>
            <div>
                <h2>Features</h2>
                <ul>
                    <li>Fully responsive</li>
                    <li>Collapsable sidebar</li>
                    <li>Multi level menu</li>
                    <li>RTL support</li>
                    <li>Customizable</li>
                </ul>
            </div>
            <div>
                <h2>Resources</h2>
                <ul>
                    <li>
                        <a target="_blank" href="https://github.com/azouaoui-med/css-pro-layout">
                            Css Pro Layout</a>
                    </li>
                    <li>
                        <a target="_blank" href="https://github.com/popperjs/popper-core"> Popper Core</a>
                    </li>
                    <li>
                        <a target="_blank" href="https://remixicon.com/"> Remix Icons</a>
                    </li>
                </ul>
            </div>
            <footer class="footer">
                <small style="margin-bottom: 20px; display: inline-block">
                    © 2022 made with
                    <span style="color: red; font-size: 18px">&#10084;</span> by -
                    <a target="_blank" href="https://azouaoui.netlify.com"> Mohamed Azouaoui </a>
                </small>
                <br />
                <div>
                    <a href="https://github.com/azouaoui-med" target="_blank" rel="noopener noreferrer">
                        <img alt="GitHub followers" src="https://img.shields.io/github/followers/azouaoui-med?label=github&style=social" />
                    </a>
                    <a href="https://twitter.com/azouaoui_med" target="_blank" rel="noopener noreferrer">
                        <img alt="Twitter Follow" src="https://img.shields.io/twitter/follow/azouaoui_med?label=twitter&style=social" />
                    </a>
                </div>
            </footer>
        </main>
        <div class="overlay"></div>
    </div>
</div>
