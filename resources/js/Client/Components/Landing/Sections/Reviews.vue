<script setup>
import { ref } from 'vue'
import { Lightbox } from '@/Client/Components/Landing/Pieces'
import { reviewsGalery } from '@/Client/Components/Landing/Utils/ReviewsGalery.js'

const isShowLightbox = ref(false)

const lightboxContent = ref({
  avatar: '',
  title: '',
  ocupation: '',
  location: '',
  review: ''
})

const openLightBox = (person) => {
  isShowLightbox.value = true
  lightboxContent.value.avatar = person.avatar
  lightboxContent.value.title = person.name
  lightboxContent.value.ocupation = person.ocupation
  lightboxContent.value.location = person.location
  lightboxContent.value.review = person.review
}

const closeLightbox = () => isShowLightbox.value = false
</script>

<template>
  <section id="reviews">
    <div class="companies-content">
      <h2 class="section-title">Reviews</h2>

      <div class="reviews galery">
        <article v-for="item in reviewsGalery" :key="item.id" @click="openLightBox(item)">
          <img :src="item.avatar" :alt="`photo of ${item.name}`">
          <h3>{{ item.name }}</h3>
          <p class="bolder">{{ item.ocupation }}</p>
          <p>{{ item.location }}</p>
        </article>
      </div>
    </div>

    <Lightbox :lightboxContent="lightboxContent" :isShowLightbox="isShowLightbox" :closeLightbox="closeLightbox" />

  </section>
</template>

<style lang="css" scoped>
.companies-content {
  background-color: #F7F7FC;
  padding: 100px 10%;
  text-align: center;
  margin: auto;
}

@media (min-width: 1280px) {
  .companies-content {
    padding: 100px 5% 150px;
  }
}

.reviews.galery {
  margin-top: 40px;
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  column-gap: 30px;
  row-gap: 50px;
}

.reviews.galery article {
  transition: transform .3s ease-in-out;
  cursor: pointer;
}

.reviews.galery article:hover {
  transform: scale(110%);
}

.reviews.galery img {
  width: 130px;
  object-position: center;
  margin: 0 auto;
}

@media (min-width: 768px) {
  .reviews.galery {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 1280px) {
  .reviews.galery {
    grid-template-columns: repeat(6, 1fr);
  }
}

.reviews.galery h3 {
  font-weight: 700;
  font-size: 20px;
  line-height: 40px;
  margin: 0;
}

.reviews.galery p {
  font-size: 14px;
  line-height: 16px;
  color: #0F4BAD;
  margin: 0;
}

.reviews.galery p.bolder {
  font-weight: 700;
}
</style>
