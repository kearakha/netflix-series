<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Netflix Series</title>
  
    <!-- icon web -->
     <link rel="icon" href="img/logo_netflix-removebg-preview.jpeg">
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!-- nav st -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
          <a class="navbar-brand" href="#">Netflix Top Series</a>
          <button 
          class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#article">Article</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#gallery">Gallery</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#schedule">Schedule</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="login.php" target="_blank">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
              <button type="button" id="darkButton" class="btn btn-dark theme" title="dark">
                <i class="bi bi-moon-fill"></i>
              </button>
              <button id="lightButton" class="btn btn-danger theme" title="light">
                <i class="bi bi-brightness-high-fill"></i>
              </button>
          </div>
        </div>
    </nav>
    <!-- nav end -->
    
    <!-- hero st -->
    <section id="hero" class="text-center p-5 bg-danger-subtle text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="https://whatflixshow.com/wp-content/uploads/al_opt_content/IMAGE/whatflixshow.com/wp-content/uploads/2024/05/Netflix-top-10.png.bv_resized_desktop.png.bv.webp" class="img-fluid" width="600" />
          <div class="m-5">
            <h1 class="fw-bold display-4">
              Top Netflix Series
            </h1>
            <h5 class="lead">Rekomendasi Tayangan yang Harus Anda Tonton.<br>
              Di halaman ini, kami menyajikan daftar seri terbaik yang tersedia di Netflix. Temukan pilihan dari berbagai genre, mulai dari drama, komedi, hingga thriller. Setiap judul dilengkapi dengan ulasan singkat untuk membantu Anda menentukan mana yang ingin ditonton. Kami mengupdate daftar ini secara berkala, sehingga Anda selalu bisa menemukan tayangan terbaru dan terpopuler di Netflix. Nikmati pengalaman menonton Anda dengan rekomendasi yang tepat!
            </h5>
            <h6>
              <span id="tanggal"></span>
              <span id="jam"></span>
            </h6>
          </div>
        </div>
      </div>
    </section>
    <!-- hero end -->

    <!-- article begin -->
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql); 

          while($row = $hasil->fetch_assoc()){
          ?>
            <div class="col">
              <div class="card h-100">
                <img src="img/<?=$row["gambar"]?>" class="card-img-top" alt="..." />
                <div class="card-body">
                  <h5 class="card-title"><?= $row["judul"]?></h5>
                  <p class="card-text">
                    <?= $row["isi"]?>
                  </p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary">
                    <?= $row["tanggal"]?>
                  </small>
                </div>
              </div>
            </div>
            <?php
          }
          ?> 
        </div>
      </div>
    </section>
<!-- article end -->

    <!-- gallery st -->
    <section id="gallery" class="night text-center p-5 bg-danger-subtle">
      <div class="container">
          <h1 class="fw-bold display-4 pb-3">Gallery</h1>
          <div id="carouselExampleIndicators" class="carousel slide">
              <div class="carousel-indicators">
              <?php
                $sql = "SELECT * FROM gallery";
                $hasil = $conn->query($sql);

                // Counter untuk slide index
                $slideIndex = 0;
                while ($row = $hasil->fetch_assoc()) {
                    // Set button pertama sebagai active
                    $active = ($slideIndex === 0) ? 'active' : '';
                    echo "<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$slideIndex' class='$active' aria-label='Slide " . ($slideIndex + 1) . "'></button>";
                    $slideIndex++;
                }
                ?>
              </div>

              <?php
                $sql = "SELECT * FROM gallery";
                $hasil = $conn->query($sql);

                $active = true; // Flag to set the first item as active
                ?>

              <div class="carousel-inner">

              <?php
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <div class="carousel-item <?= $active ? 'active' : '' ?>">
                            <img
                                src="img/<?= $row["gambar"] ?>"
                                class="d-block w-100"
                                alt="..." />
                        </div>
                    <?php
                        $active = false; // Set the flag to false after the first item
                    }
                    ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
      </div>
  </section>
    <!-- gallery end -->

    <!-- schedule start -->
    <section id="schedule" class="text-center p-5">
    <div class="container">
      <h1 class="fw-bold display-4 pb-3">Schedule</h1>
      <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2008</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Breaking Bad <br> (5 Season)
              </li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2016</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Stranger Things <br> (4 Season, S5 on 2025)
              </li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2017</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Money Heist <br> (5 Season, spin-off : "Berlin")
              </li>
              
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2021</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Lupin <br> (3 Season)
              </li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2022</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Wednesday <br> (1 Season , S2 on 2025)
              </li>
            </ul>
          </div>
        </div>
        <div class="col">
          <div class="card h-100">
            <div class="card-header bg-danger text-white">2023</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                Gadis Kretek <br> (1 Season)
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    </section>
    <!-- schedule end -->
    
    <!-- about me start -->
    <section id="about" class="text-center p-5 bg-danger-subtle">
        <div class="container">
        <h1 class="fw-bold display-4 pb-3">About Me</h1>
          <div class="d-sm-flex align-items-center justify-content-center">
            <div class="p-3">
              <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQv4cevoLuq99xsk6dNBZH2C5fpAYccB3VKHg&s"
                class="rounded-circle border shadow"
                width="300"
              />
            </div>
            <div class="isiabout">
            <div class="p-md-5 text-sm-start">
              <h3 class="lead">A11.2023.15165</h3>
              <h1 class="fw-bold">Muhammad Rakha Keanura</h1>
              Program Studi Teknik Informatika<br />
              <a href="https://dinus.ac.id/" class="fw-bold text-decoration-none"
                >Universitas Dian Nuswantoro</a
              >
            </div>
          </div>
        </div>
        </div>
    </section>
    <!-- about me end -->

    <!-- footer st -->
    <footer id="footer" class="text-center p-5">
        <div>
            <a href="https://www.instagram.com/rakhakea?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="footer bi bi-instagram h4 p-4 text-dark"></i></a>
            <a href="https://x.com/keanuraa"><i class="footer bi bi-twitter-x h4 p-4 text-dark"></i></a>
            <a href="https://wa.me/+6287882288516"><i class="footer bi bi-whatsapp h4 p-4 text-dark"></i></a>        
        </div>
        <div class="p-3 footer">
            M. Rakha Keanura &copy; 2024
        </div>
    </footer>
    <!-- footer end -->
        
     <!-- script boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- javascript date n time -->
    <script type="text/javascript">
        window.setTimeout("tampilWaktu()", 1000);

        function tampilWaktu() {
            let waktu = new Date();
            let bulan = waktu.getMonth() + 1;

            setTimeout("tampilWaktu()", 1000);
            document.getElementById("tanggal").innerHTML = 
            waktu.getDate() + "-" + bulan + "-" + waktu.getFullYear();
            
            document.getElementById("jam").innerHTML=
            waktu.getHours() + ":" + waktu.getMinutes() + ":" + waktu.getSeconds();
        }

          document.getElementById("darkButton").onclick = function () {
            document.body.style.backgroundColor = "black";

            document
              .getElementById("hero")
              .classList.remove("bg-danger-subtle", "text-black");
            document
              .getElementById("hero")
              .classList.add("bg-secondary", "text-white");

            document
              .getElementById("gallery")
              .classList.remove("bg-danger-subtle", "text-black");
            document
              .getElementById("gallery")
              .classList.add("bg-secondary", "text-white");

            document
              .getElementById("about")
              .classList.remove("bg-danger-subtle", "text-black");
            document
              .getElementById("about")
              .classList.add("bg-secondary", "text-white");

            document.getElementById("article").classList.remove("text-black");
            document.getElementById("article").classList.add("text-white");

            document.getElementById("schedule").classList.remove("text-black");
            document.getElementById("schedule").classList.add("text-white");

            const collection = document.getElementsByClassName("card");
            for (let i = 0; i < collection.length; i++) {
              collection[i].classList.add("bg-secondary", "text-white");
            }

            const collection2 = document.getElementsByClassName("list-group-item");
            for (let i = 0; i < collection2.length; i++) {
              collection2[i].classList.add("bg-secondary", "text-white");
            }

            const collection3 = document.getElementsByClassName("footer");
            for (let i = 0; i < collection3.length; i++) {
              collection3[i].classList.add("text-white");
            }
            };

        document.getElementById("lightButton").onclick = function () {
          document.body.style.backgroundColor = "white";

        document
          .getElementById("hero")
          .classList.remove("bg-secondary", "text-white");
        document
          .getElementById("hero")
          .classList.add("bg-danger-subtle", "text-black");

        document
          .getElementById("gallery")
          .classList.remove("bg-secondary", "text-white");
        document
          .getElementById("gallery")
          .classList.add("bg-danger-subtle", "text-black");

        document
          .getElementById("about")
          .classList.remove("bg-secondary", "text-white");
        document
          .getElementById("about")
          .classList.add("bg-danger-subtle", "text-black");

        document.getElementById("article").classList.remove("text-white");
        document.getElementById("article").classList.add("text-black");

        document.getElementById("schedule").classList.remove("text-white");
        document.getElementById("schedule").classList.add("text-black");

        const collection = document.getElementsByClassName("card");
        for (let i = 0; i < collection.length; i++) {
          collection[i].classList.remove("bg-secondary", "text-white");
        }

        const collection2 = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < collection2.length; i++) {
          collection2[i].classList.remove("bg-secondary", "text-white");
        }

        const collection3 = document.getElementsByClassName("footer");
            for (let i = 0; i < collection3.length; i++) {
              collection3[i].classList.remove("text-white");
            }
      };

      document.querySelector("#about").onclick = function() {
        const isiAboutText = document.querySelector(".isiabout");
        isiAboutText.style.display = isiAboutText.style.display === "none" ? "block" : "none";
      };
    </script>
</body>
</html>