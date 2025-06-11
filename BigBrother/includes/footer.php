
    <!-- Scroll to Top Button -->
    <a href="#" class="scroll-to-top">
        <i class="ri-arrow-up-line"></i>
    </a>

    <!-- FOOTER -->
    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <a href="#"><img src="./assets/images/logo.svg" alt=""></a>
                        <div class="line"></div>
                        <p data-i18n="footer_slogan">Never forget, BigBrother is watching you...</p>
                        <div class="social-icons">
                            <a href="#"><i class="ri-twitter-fill"></i></a>
                            <a href="#"><i class="ri-instagram-fill"></i></a>
                            <a href="#"><i class="ri-github-fill"></i></a>
                            <a href="#"><i class="ri-dribbble-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">INFOS</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a data-i18n="footer_research" href="#">Research</a></li>
                            <li><a data-i18n="footer_brand" href="#">Our Brand</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 data-i18n="footer_about" class="mb-0 text-white">ABOUT</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">Information</a></li>
                            <li><a href="#">Team</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACT</h5>
                        <div class="line"></div>
                        <ul>
                            <li data-i18n="footer_location">Vienna, Austria</li>
                            <li>+43 xxx xxxxxx</li>
                            <li>www.bigbrother.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-auto">
                        <p data-i18n="footer_copyright" class="mb-0">© Copyright BigBrother. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="reminder-toast" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:9999; min-width:350px; max-width:90vw;">
        <div style="background:#232323; color:#fff; border-radius:16px; padding:40px 30px; box-shadow:0 4px 24px rgba(0,0,0,0.3); text-align:center;">
            <strong id="toast-title" style="font-size:1.5rem;">Are you still studying?</strong>
            <div class="mt-4">
                <button id="btn-yes" class="btn btn-success btn-lg me-3">Yes</button>
                <button id="btn-no" class="btn btn-danger btn-lg">No</button>
            </div>
            <div id="toast-message" class="mt-4" style="display:none; font-size:1.2rem;"></div>
        </div>
    </div>


    <script>
    document.getElementById('reminder-box').addEventListener('click', function() {
        const toast = document.getElementById('reminder-toast');
        toast.style.display = 'block';
        document.getElementById('toast-title').textContent = "Are you still studying?";
        document.getElementById('toast-message').style.display = 'none';
    });

    document.getElementById('btn-yes').addEventListener('click', function() {
        const msg = document.getElementById('toast-message');
        msg.textContent = "GOOD JOB, KEEP IT UP";
        msg.style.display = 'block';
        setTimeout(() => {
           document.getElementById('reminder-toast').style.display = 'none';
            msg.style.display = 'none';
       }, 1000);
    });

    document.getElementById('btn-no').addEventListener('click', function() {
        const msg = document.getElementById('toast-message');
        msg.textContent = "THEN GET BACK TO WORK!";
        msg.style.display = 'block';
        setTimeout(() => {
            document.getElementById('reminder-toast').style.display = 'none';
            msg.style.display = 'none';
        }, 2000);
    });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/lang.js"></script>
    <script>
    document.getElementById('btn-darkmode').addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    // Optional: Icon wechseln
    this.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
    });
    </script>
    
</body>

</html>