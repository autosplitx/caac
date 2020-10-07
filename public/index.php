<?php require_once('../private/initialize.php'); ?>
<?php $page_title = 'Home'; ?>
<title><?php echo $page_title . ' | Page'; ?></title>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div class="view" style="background-image: url('<?php echo url_for('img/hcdc.jpg') ?>'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
  <!-- Mask & flexbox options-->
  <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row mt-5">
        <div class="col-md-6 mb-5 mt-md-0 mt-5 white-text text-center text-md-left">
          <h1 class="h1-responsive font-weight-bold animated fadeInLeft" delay="0.3s">SKILLS ACQUISITION PROGRAMME (CAAC)</h1>
          <hr class="hr-light animated fadeInLeft" delay="0.3s">
          <h6 class="mb-3 animated fadeInLeft" delay="0.3s">
            SKILLS ACQUISITION PROGRAMME BY COKER AGUDA AREA COUNCIL (CAAC).
          </h6>
          <a class="btn btn-outline-white btn-rounded animated fadeInLeft" delay="0.3s">Learn more</a>
        </div>
        <div class="col-md-6 col-xl-5 mb-4">
          <div class="card animated fadeInRight" delay="0.3s">
            <div class="card-body">
              <div class="text-center">
                <h3 class="white-text font-weight-bold">
                  <i class="fa fa-paper-plane white-text"></i> Enquiry:</h3>
                <hr class="hr-light">
              </div>
              <div class="md-form">
                <i class="fa fa-user prefix white-text active"></i>
                <input type="text" id="name" class="white-text form-control">
                <label for="name" class="active">Full name</label>
              </div>
              <div class="md-form">
                <i class="fa fa-envelope prefix white-text active"></i>
                <input type="email" id="subject" class="white-text form-control">
                <label for="subject" class="active">Subject</label>
              </div>
              <div class="md-form">
                <i class="fa fa-file-alt prefix white-text active"></i>
                <textarea class="form-control white-text border-top-0 border-left-0 border-right-0" id="body"></textarea>
                <label for="body">Message</label>
              </div>
              <div class="text-center mt-4">
                <button class="btn btn-indigo btn-rounded" id="sendMail">Send</button>
                <hr class="hr-light mb-3 mt-4">
                <div class="inline-ul text-center d-flex justify-content-center">
                  <a href="https://api.whatsapp.com/send?phone=2348135433395/" class="p-2 m-2" role="button" target="_blank">
                    <i class="fab fa-whatsapp fa-2x"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</header>

<main role="main" class="">
  <div class="container my-4 py-4 z-depth-1">
    <section class="text-justify px-md-5 mx-md-5 dark-grey-text">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-8">
          <p>
            From the directive of the Coker Aguda Area Council (CAAC), launched the Skills Acquisition Programme as one of her key initiatives that will empower innovators and entrepreneurs with skills required to thrive in our emerging digital economy. The Skills Acquisition Programme is a key component of the Digital Literacy and Skills Pillar of the area council.
          </p>

          <p>
            The training covers areas like Desktop Publishing, Website Development, 3D Animation, Database Administration. There is also training on soft skills like entrepreneurship, business and how to create excellent resumes. The aim is to create digital entrepreneurs, develop skills for jobs and to foster innovation among the member of the society.
          </p>

          <p>
            The council is committed to developing the capacity of her members to use technology to solve problems. We will keep updating the course offerings to reflect its intention. The Skills Acquisition Programme will provide a platform to empower the Area Council Member to develop relevant skills and build innovative solutions to address challenges within its community.
          </p>

          <p>
            The council members are encouraged to take advantage of this opportunity by registering today at :
          </p>

          <ul type="list-group">
            <li class="list-group-item text-center">Coker Aguda Area Council Portal <a href="<?php echo url_for('mail/index.php'); ?>" type="button" class="btn btn-sm btn-success rounded">Click here to register</a></li>
          </ul>
        </div>
      </div>
    </section>
  </div>

  <?php include(SHARED_PATH . '/staff_footer.php'); ?>


  <script>
    $('#sendMail').on('click', function() {
      var name = $('#name');
      // var email = $('#emailAddress');
      var subject = $('#subject');
      var body = $('#body');

      if (isNotEmpty(name) && isNotEmpty(subject) && isNotEmpty(body)) {
        $.ajax({
          url: 'mail/mail.php',
          method: 'post',
          dataType: 'JSON',
          data: {
            name: name.val(),
            // email: email.val(),
            subject: subject.val(),
            body: body.val()
          },
          success: function(r) {
            console.log(r);
            if (r.status == 'success') {
              alert(r.response);
              name.val('');
              subject.val('');
              body.val('');
            }
            // else {
            //   alert(r.status);
            // }
          },
          error: function(xhr) {
            alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
          }
        });
      }

      function isNotEmpty(caller) {
        if (caller.val() == '') {
          caller.css('borderBottom', '1px solid red');
          return false;
        } else {
          caller.css('border', '');
          return true;
        }
      }
    });
  </script>