<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { LandingButton } from '@/Client/Components/Landing/Pieces'

const user = computed(() => usePage().props.value.auth?.user)
</script>

<template>
  <section id="about-us">
    <div class="about-container">
      <h2 class="section-title">About Us</h2>
      <p class="font-base text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam atque blanditiis dolore earum fuga iste magni neque, optio possimus, reprehenderit sit, tenetur! Atque fugit mollitia odit optio quisquam sit suscipit.
      </p>
      <p class="font-base text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus dolorum est facere harum nemo neque nesciunt nobis? Assumenda, ea explicabo illo ipsum laboriosam modi natus non quis totam ut vitae?
      </p>
      <p class="font-base text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, architecto veritatis. Aliquam, animi aperiam autem expedita fugiat fugit ipsa laborum natus neque quia repellat sed similique tempora velit vero voluptates!
      </p>
      <p class="font-base text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, repellendus. </p>
      <p class="font-base text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias deleniti doloremque ipsum minima perferendis perspiciatis quod reprehenderit repudiandae veritatis voluptates! </p>
      <p class="font-base text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aperiam deserunt eaque enim ipsa modi nihil numquam quaerat quasi quis quisquam repellendus, sapiente similique sint sit, tempora, veniam vitae voluptates.
      </p>
      <p class="font-base text-justify">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus consectetur doloribus ea fugit hic ipsa ipsam laboriosam, maiores placeat repellendus. Aliquam, deserunt enim necessitatibus quaerat quibusdam similique! Nemo, suscipit, totam!
      </p>
      <p class="font-base text-justify">
       Emergency is free while in BETA mode. So Join now!
      </p>
      <div class="center-button">
        <LandingButton
          :navigation=" user ? 'dashboard.contracts.open' : 'join.index'"
          :buttonText=" user ? 'Dashboard' : 'Join today'"
          :hasArrow="true"
        />
      </div>
    </div>
  </section>
</template>

<style lang="css" scoped>
#about-us {
  background-color: #fff;
  padding: 100px 0px;
}

.about-container {
  margin: 0 55px;
  color: #4E4B66;
}

.about-container p:nth-child(2),
.about-container p:nth-child(3),
.about-container p:nth-last-child(2) {
  font-weight: 600;
}

.center-button {
  text-align: center;
  margin-top: 50px;
}

@media (min-width: 768px) {
  .about-container {
    margin: 0 140px;
  }
}

@media (min-width: 1280px) {
  .center-button {
    margin-top: 75px;
  }
}

@media (min-width: 1536px) {
  .about-container {
    margin: 0 400px;
  }
}
</style>
