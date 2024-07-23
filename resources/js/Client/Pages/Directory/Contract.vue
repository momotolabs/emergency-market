<script setup>
import { ref } from "vue";
import { Default } from "@/Client/Layouts/";
import { Button } from "@/Client/Components/Form";
import { StartIcon } from "@/Client/Components/Icons";
import { Modal } from "@/Client/Components/Shared";
import {
  ResourcesTable,
  ContractContent,
} from "@/Client/Components/Shared/Contract";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";

import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";
import { FreeMode, Navigation, Thumbs } from "swiper";
let thumbsSwiper = ref();
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};

const props = defineProps([
  "company",
  "avatar",
  "gallery",
  "contract",
  "resources",
]);

const isModalVisible = ref(false);
const getYtId = (video_url) => {
  const regex =
    /(?:youtube(?:-nocookie)?\.com\/(?:[^/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/im;
  const ids = regex.exec(video_url);
  return ids[1];
};

const closeModal = () => (isModalVisible.value = false);
</script>

<template>
  <Default>
    <div class="bg-white shadow-lg rounded-lg p-5 font-inter">
      <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-300 pb-4 space-y-4 md:space-y-0"
      >
        <div class="flex flex-row around items-center space-x-4">
          <img
            v-if="props.avatar !== null"
            :src="props.avatar['path']"
            alt=""
            class="w-20"
          />
          <div>
            <span>{{ props.company.name }}</span>
            <div class="flex flex-row space-x-2">
              <StartIcon />
              <span>{{ props.id }}/5 (reviews)</span>
            </div>
          </div>
        </div>
        <div class="w-[250px] max-w-[250px]" v-if="props.contract">
          <Button
            @click="
              $inertia.get(
                route('directory.hire', {
                  state: props.company.city.state.iso_code,
                  city: props.company.city.slug,
                  company: props.company.slug,
                })
              )
            "
          >
            Hire Company
          </Button>
        </div>
      </div>

      <div
        class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-10 mt-4"
      >
        <!-- embebed video -->
        <div class="w-full"
          :class="[ props.resources.length < 18 ? 'lg:w-[70%]' : 'lg:w-[40%]' ]"
        >
          <Swiper
            :style="{
              '--swiper-navigation-color': '#fff',
              '--swiper-pagination-color': '#fff',
            }"
            :spaceBetween="10"
            :navigation="true"
            :thumbs="{ swiper: thumbsSwiper }"
            :modules="[FreeMode, Navigation, Thumbs]"
            class="mySwiper2"
          >
            <swiper-slide v-if="props.company?.main_video">
              <iframe
                class="w-full h-80 md:h-96 xl:h-[600px]"
                :src="`https://www.youtube.com/embed/${getYtId(
                  props.company?.main_video
                )}`"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
              ></iframe>
            </swiper-slide>
            <swiper-slide v-for="(item, index) in props.gallery" :key="index">
              <img
                class="w-full h-80 md:h-96 xl:h-[600px]"
                :src="item.path"
                :alt="`image${index}`"
              />
            </swiper-slide>
          </Swiper>
        </div>

        <!-- pricing resources -->
        <div class="w-full">
          <h2 class="text-xl font-medium">Resources and pricing</h2>
          <ResourcesTable :resources="props.resources" />

          <div class="space-y-4 mt-4" v-if="props.contract">
            <Button :secundary="true" @click="isModalVisible = true">
              View contract
            </Button>

            <Button
              @click="
                $inertia.get(
                  route('directory.hire', {
                    state: props.company.city.state.iso_code,
                    city: props.company.city.slug,
                    company: props.company.slug,
                  })
                )
              "
            >
              Hire Company
            </Button>
          </div>
        </div>
      </div>

      <!-- description -->
      <div class="mt-4">
        <div class="w-full lg:w-[calc(80%_-_30px)]">
          <swiper
            @swiper="setThumbsSwiper"
            :spaceBetween="10"
            :slidesPerView="4"
            :freeMode="true"
            :watchSlidesProgress="true"
            :modules="[FreeMode, Navigation, Thumbs]"
            class="mySwiper"
          >
            <swiper-slide v-if="props.company?.main_video">
              <img
                class="figure-item"
                :src="`http://i3.ytimg.com/vi/${getYtId(props.company?.main_video)}/hqdefault.jpg`"
                alt="asdas"
              />
            </swiper-slide>
            <swiper-slide v-for="image in props.gallery">
              <img :src="image.path" />
            </swiper-slide>
          </swiper>
        </div>
        <h3 class="text-xl font-medium 300 pt-5 pb-2">Directory</h3>
        <p class="whitespace-pre-line">{{ props.company.description }}</p>
      </div>
    </div>

    <Modal
      :is-modal-visible="isModalVisible"
      titleModal="Contract"
      :close-modal="closeModal"
    >
      <div class="p-5">
        <div>
          <ContractContent :content="props.contract?.content" />
        </div>
        <h2 class="text-xl font-medium border-b border-gray-300 pt-5 pb-2">
          Hourly Rates
        </h2>
        <ResourcesTable :resources="props.resources" />
      </div>
    </Modal>
  </Default>
</template>

<style>
.mySwiper {
  height: 20%;
  box-sizing: border-box;
  padding: 10px 0;
  cursor: grab;
}

.mySwiper .swiper-slide {
  width: 25%;
  height: 100%;
  opacity: 0.4;
}

.mySwiper .swiper-slide-thumb-active {
  opacity: 1;
}

</style>
