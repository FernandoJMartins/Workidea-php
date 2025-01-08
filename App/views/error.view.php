<?= loadPartials('head'); ?>
<?= loadPartials('header'); ?>



<section>
      <div class="container mx-auto p-4 mt-4">
         <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3"><?= $status ?></div>
         <p class="text-center text-2xl mb-4">
            <?= $msg ?>
         </p>
         <a class="block text-center" href="/public/listings/">Go back to Listings</a>
      </div>
      </section>



<?= loadPartials('footer'); ?>