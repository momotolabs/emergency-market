<script setup>
import pathCardProvider from '@/Client/assets/images/Landing/bennefit-contract.png'
import pathCardConsumer from '@/Client/assets/images/Landing/bennefit-customer.png'
import { SlideBenefitMobileItem, SlideBenefitDesktopItem } from '@/Client/Components/Landing/Utils/BenefitSlideItem.js'
import { BenefitsCard } from '@/Client/Components/Landing/Pieces'
import { Carrousel } from '@/Client/Components/Landing/Slide/index.js'

</script>
<template>
  <section id="benefits">

    <div class="benefits-banner">
      <div class="slide-mobile">
        <Carrousel :slides="SlideBenefitMobileItem" />
      </div>
      <div class="slide-desktop">
        <Carrousel :slides="SlideBenefitDesktopItem" />
      </div>
    </div>

    <div class="cards-content">
      <BenefitsCard :backgroundCard="pathCardProvider">
        <h4 class="">Contractor benefits</h4>
        <p class="bolder">Instantly deploy emergency resources faster than ever,
          eliminating on-site estimates, while still receiving instant market comparables to support your pricing at
          time of invoice generation </p>
        <p>Join our free online insurance claim training class! <br> Be part of the discussion in our ever-growing
          community of emergency mitigators supporting each other and uplifting the industry!</p>
      </BenefitsCard>

      <BenefitsCard :backgroundCard="pathCardConsumer">
        <h4 class="">Customers benefits</h4>
        <p class="bolder">Keep your family safer by choosing from top notch tree services who know how to get your tree
          off quickly and safely. You’ll be able to easily pick and choose between services in your area without having
          to spend time waiting for them to come out to put a price tag on your fallen tree. </p>
        <p>After the job is done, When the tree contractor creates the invoice, our system will automatically create
          comparables using the hours that it took to do your job, but forecasted at the rates the other companies in
          the area would have charged had you gone with them instead. This way you get the estimates to support your
          choice, without waiting under the danger of a Fallen Tree in order to get them.</p>
      </BenefitsCard>
    </div>
  </section>
</template>

<style lang="css" scoped>
#benefits {
  background-color: #14142A;
}

.slide-desktop,
.slide-mobile {
  height: 100%;
  width: 100%;
}

.slide-desktop {
  display: none;
}

@media (min-width: 768px) {
  .slide-mobile {
    display: none;
  }

  .slide-desktop {
    display: block;
  }
}

.benefits-banner {
  height: calc(100vh - 80px);
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  background-attachment: fixed;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  align-items: center;
  color: #fff !important;
  text-align: center;
  padding-top: 80px;
}

.benefits-banner::after {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
}

.benefits-banner p {
  font-size: 22px;
  line-height: 30px;
  text-align: justify;
  font-weight: 400;
}

@media (min-width: 768px) {
  .benefits-banner p {
    text-align: center;
  }
}

.benefits-banner .banner-content {
  z-index: 10;
  padding: 0 55px;
}

@media (min-width: 1280px) {
  .benefits-banner.banner-content {
    max-width: 50%;
  }
}

@media (min-width: 768px) {
  .benefits-banner {
    padding-top: 100px;
  }
}

.cards-content {
  display: grid;
  row-gap: 100px;
  padding: 100px 50px;
}

.cards-content h4 {
  color: #fff;
  font-family: 'Inter';
  font-weight: 400;
  text-align: center;
  font-size: 18px;
  line-height: 35px;
}

@media (min-width: 768px) {
  .cards-content h4 {
    font-size: 35px;
  }
}

.cards-content p {
  line-height: 20px;
  font-weight: 300;
  font-size: 10px;
  text-align: justify;
}

@media (min-width: 1280px) {
  .cards-content p {
    font-size: 18px;
    line-height: 30px;
  }
}

p.bolder {
  font-weight: 700 !important;
}

@media (min-width: 768px) {
  .cards-content {
    grid-template-columns: repeat(2, 1fr);
    column-gap: 20px;
    max-width: 100%;
    margin: auto;
  }
}

@media (min-width: 1024px) {
  .cards-content {
    max-width: 75%;
  }
}
</style>
