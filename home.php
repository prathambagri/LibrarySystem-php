<!-- Start Header Section -->
<div class="banner">
    <div class="overlay">
        <div class="container">
            <div class="intro-text">
                <h1>Welcome To The <span>Online Library</span></h1>
                <p>Explore and Borrow Books <br> Online</p> 
            </div>
        </div>
    </div>
</div>
<!-- End Header Section -->
    
<!-- Start About Us Section -->
<section id="about-section" class="about-section">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                <h2>About Us</h2>
            </div>                        
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="about-img">
                <img src="asset\images\jaredd-craig-HH4WBGNyltc-unsplash.jpg" class="img-responsive" alt="About images">
            </div>
        </div>
        <div class="col-md-7">
            <div class="about-text">
                <p>This online library management system is a software application designed to automate and streamline the processes involved in managing a library.</p>
                <p>Implementing these features can enhance the efficiency, accessibility, and overall functionality of an online library management system.</p>
            </div>
            
            <div class="about-list">
                <h4>Some important Feature</h4>
                <ul>
                    <li><i class="fa fa-check-square"></i>Allow users to register and create individual accounts.</li>
                    <li><i class="fa fa-check-square"></i>Maintain a comprehensive database of all library resources.</li>
                    <li><i class="fa fa-check-square"></i>Include details such as title, author, publication date and category.</li>
                    <li><i class="fa fa-check-square"></i>Keep track of the availability and location of each item in the library.</li>
                    <li><i class="fa fa-check-square"></i>Update inventory status in real-time as items are checked in or out.</li>
                    <li><i class="fa fa-check-square"></i>Manage user profiles, including personal information, borrowing history.</li>
                </ul>
                
                <h4>More Feature</h4>
                <ul>
                    <li><i class="fa fa-check-square"></i>Provide a powerful and user-friendly search interface to help users find resources quickly.</li>
                    <li><i class="fa fa-check-square"></i>Enable users to check out and return items electronically.</li>
                    <li><i class="fa fa-check-square"></i>Facilitate communication between admin and users.</li>
                </ul>
            </div>
            
        </div>
   
    </div>
</div>
</section>
    
<!-- Start Call to Action Section -->
<section class="call-to-action">
<div class="container">
    <div class="row">
        <div class="col-md-12 wow zoomIn" data-wow-duration="2s" data-wow-delay="300ms">
            <p>Borrow your favourite book. <br>Read anytime & anywhere.</p>
        </div>
    </div>
</div>
</section>
<!-- End Call to Action Section -->      
    
<!-- Start Service Section -->
<section id="service-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                    <h2>Best Selling Books</h2>
                </div>                        
            </div>
        </div>

                <!-- Start Service Section -->

                <?php
            // `AccessionNo`, `BookTitle`, `BookDesc`, `Author`, `PublishDate`, `BookPublisher`, `Category`, `BookPrice`, `BookQuantity`, `Status`, `BookType`, `DeweyDecimal`, `OverAllQty`, `Donate`, `Remarks`
            
                    // $mydb->setQuery("SELECT *, sum(BookQuantity) as qty FROM `tblbooks` GROUP BY BookTitle");
            $mydb->setQuery("SELECT * FROM `tblbooks` WHERE Status='Available' GROUP BY BookTitle"); 
                    $cur = $mydb->loadResultlist();
                    foreach ($cur as $result) {
                        echo '<tr>'; 
                        // echo '<td ><input type="checkbox" name="selector[]" id="selector[]" value="'.$result->SUBJ_ID. '"/>
                        //      <a href="index.php?view=edit&id='.$result->SUBJ_ID.'">' . $result->SUBJ_CODE.'</a></td>';
                        // echo '<td >' . $result->IBSN.'</td>';
                        // echo '<td >'. $result->BookTitle.'</td>';
                        // echo '<td>'.  $result->BookDesc.'</td>'; 
                        // echo '<td>'. $result->Category.'</td>'; 
                        // echo '<td>'. $result->Author.'</td>';
                        // echo '<td>'. $result->BookPrice.'</td>';
                        // echo '<td>'. $result->Status.'</td>';
                        // echo '<td>'. $result->qty.'</td>';

                        echo '<div class="col-md-3">
                                    <div class="services-post">
                                        <a href="index.php?q=borrow&id='.$result->IBSN.'"><i class="fa fa-book"></i></a>
                                        <h2>'. $result->BookTitle.'</h2>
                                        <p>'.  $result->BookDesc.'</p>
                                    </div>
                                </div>';

                } 
            ?>

    </div>
</section>
