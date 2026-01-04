<?php session_start(); ?>
<?php
include 'config.php';


$query = "SELECT id, menu_name, menu_details, price, image 
          FROM vendor_menu 
          ORDER BY RAND() 
          LIMIT 8";


$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>TastyWheel | Home</title>
</head>

<body>
  <header>
    <div class="header">
      <div class="headerbar">
        <div class="account">
          <ul>
            <a href="">
              <li>
                <i class="fa-solid fa-house-chimney">
                </i>
              </li>
            </a>
            <a href="#">
              <li>
                <i class="fa-solid fa-magnifying-glass searchicon" id="searchicon1">
                </i>
              </li>
            </a>
            <div class="search" id="searchinput1">
              <input type="search">
              <i class="fa-solid fa-magnifying-glass srchicon">
              </i>
            </div>
            <a href="">
              <li>
                <i class="fa-solid fa-user" id="user-mb">
                </i>
              </li>
            </a>
            <?php if (!isset($_SESSION['user_id'])): ?>
              <a href="register.php">Register </a>
              <a href="login.php"> Login</a>
            <?php else: ?>
              <a href="logout.php">Logout</a>
            <?php endif; ?>
          </ul>
        </div>
        <div class="nav">
          <ul>
            <a href="">
              <li>Home</li>
            </a>
            <a href="about.php">
              <li>About</li>
            </a>
            <a href="order_menu.php">
              <li>Menu</li>
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
              <a href="order.php">
                <li>Order</li>
              </a>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="logo">
        <img src="./images/logo.png" alt="TastyWheel Logo">
      </div>
      <div class="bar">
        <i class="fa-solid fa-bars"></i>
        <i class="fa-solid fa-xmark" id="hdcross"></i>
      </div>
      <div class="nav">
        <ul>
          <a href="#">
            <li>Home</li>
          </a>
          <a href="about.php">
            <li>About</li>
          </a>
          <a href="order_menu.php">
            <li>Menu</li>
          </a>
          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="order.php">
              <li>Order</li>
            </a>
          <?php endif; ?>
        </ul>
      </div>
      <div>
        <div class="account">
          <ul>
            <a href="#">
              <li>
                <i class="fa-solid fa-house-chimney">
                </i>
              </li>
            </a>
            <a href="#">
              <li>
                <i class="fa-solid fa-magnifying-glass searchicon" id="searchicon2">
                </i>
              </li>
            </a>
            <div class="search" id="searchinput2">
              <input type="=search">
              <i class="fa-solid fa-magnifying-glass srchicon">
              </i>
            </div>
            <a href="#">
              <li>
                <i class="fa-solid fa-user" id="user-lap">
                </i>
              </li>
            </a>
            <?php if (!isset($_SESSION['user_id'])): ?>
              <a href="register.php">Register </a>
              <a href="login.php"> Login</a>
            <?php else: ?>
              <a href="logout.php">Logout</a>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <div class="home">
    <div class="main_slide">
      <div>
        <h1>Bet <span> You'll Never</span> Regret</h1>
        <p>Slow cooked to perfection, our authentic fish finger is packed with tender fish, perfect blend of spices and aromatic flavours!. Order online to get your food at doorstep. Dine-in Everything you order will serve hot & fresh at the branch.</p>

        <a href="https://www.facebook.com/profile.php?id=61568983745921" target="_blank"><button class="red_btn">Visit now <i class="fa-solid fa-arrow-right-long"></i></button>
      </div>

      <img src="./images/burger 3.png" alt="burger">

    </div>
    <div class="food-items">
      <div class="item">
        <div>
          <img src="./images/roastedpotato2.jpg" alt="roastedpotato">
        </div>
        <h3>Food name</h3>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit, iure.</p>
        <a href="order_menu.php"><button class="white_btn">See Menu</button></a>
      </div>
      <div class="item">
        <div>
          <img src="./images/sandwich2.jpg" alt="sandwich">
        </div>
        <h3>Food name</h3>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit, iure.</p>
        <a href="order_menu.php"><button class="red_btn">See Menu</button></a>
      </div>
      <div class="item">
        <div>
          <img src="./images/meatbox2.jpg" alt="meatbox">
        </div>
        <h3>Food name</h3>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit, iure.</p>
        <a href="order_menu.php"><button class="white_btn">See Menu</button></a>
      </div>
    </div>
    <div class="main_slide2">
      <div class="fooding">
        <img src="./images/plate1.jpg" alt="plate1">
      </div>
      <div class="question">
        <div>
          <h2>Why People Choose us?</h2>
        </div>
        <div>
          <div class="q-ans">
            <div>
              <img src="./images/plate2.jpg" alt="plate2">
            </div>
            <div>
              <h4>Burgers</h4>
              <p>Choose your favourite burger, pick a side and get a regular drink for only 250 BDT.</p>
            </div>
          </div>
          <div class="q-ans">
            <div>
              <img src="./images/plate3.jpg" alt="plate3">
            </div>
            <div>
              <h4>Chicken Burger with French Fries</h4>
              <p>Start your new year off the right way with this TastyWheel Bundle of 230 BDT. </p>
            </div>
          </div>
          <div class="q-ans">
            <div>
              <img src="./images/plate4.jpg" alt="plate4">
            </div>
            <div>
              <h4>Potato with Mayo</h4>
              <p>Enjoy the best Potato with Mayo of this town.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main_slide3">
      <div class="fav-head">
        <h3>Our Polpular Items</h3>
        <p>
          <i>Delicious meals just a click away!</i>
        </p>
      </div>
 <div class="fav-food">
<?php if($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="item">
            <div>
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                     alt="<?php echo htmlspecialchars($row['menu_name']); ?>">
            </div>

            <h3><?php echo htmlspecialchars($row['menu_name']); ?></h3>

            <p>
                <?php echo htmlspecialchars($row['menu_details']); ?>
            </p>

            <p class="fav-price">
                <?php echo $row['price']; ?> BDT
            </p>

            <!-- ✅ Add to Cart Form -->
            <form action="add_to_cart.php" method="POST" class="cart-form">
                <input type="hidden" name="menu_id" value="<?php echo $row['id']; ?>">

                <input type="number" name="qty" value="1" min="1" class="qty">

                <button type="submit" class="add-cart-btn">
                    Add to Cart
                </button>
            </form>

        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No menu available right now.</p>
<?php endif; ?>
</div>

      <div class="dsgn"></div>
    </div>
    <div class="letter">
      <div class="letter-head">
        <h2>Subscribe <span>TastyWheel</span></h2>
      </div>
      <div class="letter-input">
        <div>
          <input type="email" placeholder="Enter your email:">
        </div>
        <button class="red_btn">Subscribe</button>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="footer-1">
      <div class="logo">
        <img src="./images/logo.png" alt="logo">
      </div>
      <div>
        <address>
          <p>Email: tastywheel1220@gmail.com</p>
          <p>Youtube: TastyWheel</p>
          <p>Police Plaza,</br> Gulshan 1, Dhaka 1212 </br> Bangladesh</p>
        </address>
      </div>
    </div>

    <div class="footer-2">
      <img src="./images/photon.jpeg" alt="groupphoto">
      <h2>Powered by <em>Photon</em></h2>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>