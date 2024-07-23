<script setup>
import { ref, computed } from 'vue'
import Mitigation from '@/Client/assets/images/Landing/man-on-fire.jpg'
import Trees from '@/Client/assets/images/Landing/house-broken-one.jpg'
import TarpingRoofing from '@/Client/assets/images/Landing/house-broken-two.jpg'
import { Carrousel } from '@/Client/Components/Landing/Slide/index.js'
import { ServicesCard, LandingButton } from '@/Client/Components/Landing/Pieces/index.js'
import { usePage } from '@inertiajs/inertia-vue3'

const servicesSlides = ref([
  {
    background: Mitigation,
    title: 'Water and Fire Mitigation',
    description: '(coming soon)',
  },
  {
    background: Trees,
    title: 'Emergency Tree Services',
    description: '',
  },
  {
    background: TarpingRoofing,
    title: 'Tarping Roofing and Board Up',
    description: '(coming soon)',
  }
])

const user = computed(() => usePage().props.value.auth?.user)
</script>

<template>
  <section id="services">
    <div class="services-container">
      <h2 class="section-title">Services</h2>
      <div class="mb-5">
        <iframe
          class="w-full h-44 md:h-[25rem] xl:h-[35rem]"
          src="https://www.youtube.com/embed/C81PyOKhFys"
          title="How emergency Market Works"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen>
        </iframe>
      </div>
      <p class="font-base text-justify">emergency Market Offers online contract signing with hourly rates & auto
        downloadable comparables for emergency tree services.</p>
      <p class="font-base text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias amet animi aspernatur assumenda commodi culpa cumque ea, eligendi expedita impedit ipsam magni maxime minima nesciunt quo soluta ut vero voluptatum? </p>
      <p class="font-base text-justify">We need a system that has a common baseline, and emergency Market has created it.
      </p>
    </div>
    <div class="services-slider">
      <Carrousel :slides="servicesSlides" />
    </div>
    <div class="card-services">
      <ServicesCard :backgroundCard="Mitigation" class="hidden">
        <h3>Water and Fire Mitigation</h3>
        <span>(coming soon)</span>
      </ServicesCard>
      <ServicesCard :backgroundCard="Trees" class="hidden">
        <h3>Emergency Tree Services</h3>
      </ServicesCard>
      <ServicesCard :backgroundCard="TarpingRoofing" class="hidden">
        <h3>Tarping Roofing and Board Up </h3>
        <span>(coming soon)</span>
      </ServicesCard>
    </div>
    <div class="services-container">
      <p class="font-base text-justify bold-medium">How does it work?</p>
      <p class="font-base text-justify bold-medium">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, nihil saepe. Ad architecto dolorum, ducimus eligendi illum nulla officia reprehenderit tempore veritatis voluptatibus? Dignissimos dolores esse obcaecati odit rem sequi. </p>
      <p class="font-base text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur in ipsam nemo reprehenderit vel voluptatum. A beatae consectetur magni minima molestias ratione repellendus sed vero. Culpa dignissimos fugiat voluptatem.</p>
      <p class="font-base text-justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium atque blanditiis dolor inventore perspiciatis quis recusandae, saepe sapiente sit tempore, unde velit voluptate. Accusantium asperiores fuga qui sunt, tempora voluptatibus.</p>
      <p class="font-base text-justify">Sign Up FREE Today At URL</p>
      <div class="center-button">
        <LandingButton
          :navigation=" user ? 'dashboard.contracts.open' : 'join.index'"
          :buttonText="user ? 'Dashboard' : 'Sign Up'"
        />
      </div>
    </div>
  </section>
</template>

<style lang="css" scoped>
#services {
  background-color: var(--background);
  padding: 0 50px;
}

@media (min-width: 1024px) {
  #services {
    padding: 0 140px;
  }
}

.services-container {
  color: #4E4B66;
}

.center-button {
  text-align: center;
  padding: 70px 0px 100px;
}

.bold-medium {
  font-weight: 600;
}

.services-container h2 {
  padding-top: 100px;
}

.card-services {
  display: grid;
  margin: 20px 0px;
}

.card-services h3 {
  color: #fff;
  font-weight: 700;
  font-size: 25px;
  line-height: 35px;
}

.card-services span {
  color: #fff;
  font-weight: 400;
  font-size: 17px;
}

@media (min-width: 768px) {
  .card-services {
    grid-template-columns: repeat(3, 1fr);
    column-gap: 20px;
    margin: 60px 0px;
  }

  .card-services h3 {
    font-size: 32px;
  }
}

.services-container {
  max-width: 1110px;
  margin: 0 auto;
}

@media (min-width: 1536px) {
  .card-services {
    width: 80%;
    margin: 100px auto;
  }
}

/* end */
.card-services .hidden {
  display: none;
}

@media (min-width: 768px) {
  .card-services .hidden {
    display: block;
  }
}

.services-slider {
  width: 100%;
  height: 300px;
  border-radius: 32px;
  overflow: hidden;
  position: relative;
}

.services-slider::after {
  background: rgba(20, 20, 42, .5);
  content: "";
  height: 100%;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}

@media (min-width: 768px) {
  .services-slider {
    display: none;
  }
}
</style>
