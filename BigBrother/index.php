<?php
session_start();
include('includes/db.php');
include('includes/header.php');
include('includes/nav.php');
?>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">Welcome to BigBrother</h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">BIGBROTHER IS HERE TO HELP YOU</h5>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <div data-aos="fade-up" data-aos-delay="50">
                            <a href="login.php" class="btn btn-brand me-2">Login</a>
                            <a href="register.php" class="btn btn-light ms-2">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>


    <!-- ABOUT -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="50">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">About us</h1>
                        <div class="line"></div>
                        <p>A web-app that is designed to help students with organization and accountability</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6" data-aos="fade-down" data-aos-delay="50">
                    <img src="./assets/images/about.jpg" alt="" class="about-image">
                </div>
                <div data-aos="fade-down" data-aos-delay="150" class="col-lg-5">
                    <h1>About BigBrother</h1>
                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit quo reiciendis ad.</p>
                    <div class="d-flex pt-4 mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-user-2-fill"></i>
                        </div>
                        <div>
                            <h5>Student-centered Design</h5>
                            <p>Consectetur adipisicing elit. Corporis nesciunt aut temporibus!</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-user-5-fill"></i>
                        </div>
                        <div>
                            <h5>Improve Time Management</h5>
                            <p>Consectetur adipisicing elit. Corporis nesciunt aut temporibus!</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="iconbox me-4">
                            <i class="ri-rocket-2-fill"></i>
                        </div>
                        <div>
                            <h5>We hold you accountable</h5>
                            <p>Consectetur adipisicing elit. Corporis nesciunt aut temporibus!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMATION -->
    <section id="information" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">What we provide</h1>
                        <div class="line"></div>
                        <p>Here are some of the features that our web-app provides in order to help you in your academic journey.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-pen-nib-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Tailored To-Do</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-stack-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Easy Task Completion</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-ruler-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Personal Calendar</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-pie-chart-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Stress Management</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="550">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-rocket-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Daily Reminders</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="650">
                    <div class="information theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-user-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Personal Insights</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet fugiat sunt distinctio?</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section id="team" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Team Members</h1>
                        <div class="line"></div>
                        <p>A young team of developers who truly understand the struggles of students</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/placeholder.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Senol Aydin</h4>
                            <p class="mb-0 text-white">Fronend/Backend-Development</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/alberta.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Alberta Hasi</h4>
                            <p class="mb-0 text-white">Team Leader, Frontend/Backend-Development, Design</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mx-auto" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/placeholder.jpg" alt="">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Stephan Schlager</h4>
                            <p class="mb-0 text-white">Fronend/Backend-Development</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
include('includes/footer.php');
?>