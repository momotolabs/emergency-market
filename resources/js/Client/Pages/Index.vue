<script setup>
import LandingHeader from '@/Client/Components/Landing/LandingHeader.vue';
import LandingFooter from '@/Client/Components/Landing/Footer.vue'
import { Benefits, Services, AboutUs, OurPurpose, Reviews } from '@/Client/Components/Landing/Sections'

</script>

<template>
  <div id="landing-page">
    <LandingHeader />
      <main>
        <Benefits />

        <Services />

        <AboutUs />

        <OurPurpose />

        <Reviews />
      </main>
    <LandingFooter />
  </div>
</template>
<style lang="css">
html {
  scroll-behavior: smooth !important;
  scroll-padding: 100px;
}

.font-base {
  font-weight: 400;
  font-size: 14px;
  line-height: 24px;
}

@media (min-width: 1024px) {
  .font-base {
    font-size: 17px;
    line-height: 37px;
  }
}

.text-justify {
  text-align: justify;
}

.text-center {
  text-align: center;
}

.section-title {
  font-weight: 700;
  font-size: 30px;
  line-height: 32px;
  text-align: center;
}

.section-title__white {
  color: #fff;
}

@media (min-width: 1024px) {
  .section-title {
    line-height: 36px;
  }
}
</style>
