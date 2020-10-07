<?php require_once('../private/initialize.php'); ?>
<?php $page_title = 'About'; ?>
<title><?php echo $page_title . ' | Page'; ?></title>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<style>
  @media (max-width: 740px) {
    .aboutImg img {
      margin-top: 3.5rem;
    }
  }

  @media (min-width: 800px) and (max-width: 850px) {
    .aboutImg img {
      margin-top: 3.5rem;
    }
  }

  @media (max-width: 991px) {
    .aboutImg img {
      margin-top: 3.5rem;
    }
    iframe{
      width: 100%;
    }
  }
</style>

<div class="d-flex justify-content-center aboutImg">
  <img src="img/about2.png" class="img-fluid w-100">
</div>
<!-- <div class=" pl-0 pr-0 shadow-sm"> -->
<!-- <main role="main" class=" bg-white"> -->
<main role="main">
<div class="container my-4 py-4 z-depth-1">
  <section class="firm bg-white p-4 text-justify">
    <h5 class="">Skills Acquisition</h5>
    <hr class="mt-4 mb-4">

    <p>
      The society, Muslim Students' Society of Nigeria, is the meeting point for all Muslim Students in all Higher Institutions, Secondary Schools in most part (if not all), graduate and Post Graduates as well as Muslims who attend technical institution, like the craftsmen and women in Nigeria. Frankly speaking, this society has one of the largest spread of society in (religious or otherwise) in the whole of Nigeria.
    </p>

    <p>
      In view of this, <em>Coker Aguda Area Council (CAAC)</em> have requested your participation in filling out the below survey for the skills acquisition programme.
    </p>

    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSccpEUydujuKKyLirkLmDvlLsvHlwCQ4n26nEGelgX_BLLugg/viewform?embedded=true" width="640" height="1779" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
  </section>
</div>
  <!-- <section class="statement p-4 bg-white border-top">
    <div class=" text-justify">
      <div class="row">
        <div class="col-md-4">
          <h5>Vision Statement</h5>
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta dolore cumque fugit. Fuga natus quod, perferendis accusantium tempore at doloribus?</p>
        </div>
        <div class="col-md-4">
          <h5>Mission Statement</h5>
          <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dicta dolore cumque fugit. Fuga natus quod, perferendis accusantium tempore at doloribus?</p>
        </div>
        <div class="col-md-4">
          <div class="join p-4 border">
            <h5>Join Our Team</h5>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque accusantium eum labore dolorem, neque dignissimos!</p>
            <button class="btn btn-sm btn-danger">Contact Us</button>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <?php include(SHARED_PATH . '/staff_footer.php'); ?>