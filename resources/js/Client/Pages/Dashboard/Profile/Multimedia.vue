<script setup>
import { ref } from 'vue'
import { AdminLayout } from "@/Client/Layouts";
import { ProfileTabNav, LightboxGalery } from "@/Client/Components/Shared";
import { Fieldset, Input, Button } from "@/Client/Components/Form";
import { AvatarPicker, GaleryPicker } from "@/Client/Components/ImagePickers";
import placeholderPicture from '@/Client/assets/admin/avatar-placeholder.png'
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { DeleteFileIcon } from '@/Client/Components/Icons'
import { required } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";

const props = defineProps(["avatar", "gallery", "video"]);

const inputAvatar = useForm({
  avatar: null,
});

const inputGallery = useForm({
  images: null,
});

const mainVideo = useForm({
  video: props.video ? props.video : ''
})

const imageLighboxGalery = ref('')
const isShowGalery = ref(false)

const files = ref([])

const rules = {
  video: { required }
}

const $externalResults = ref({});

const v$ = useVuelidate(rules, mainVideo, { $externalResults });

const closeImageLightbox = () => isShowGalery.value = false

const showInLightbox = (imagePath) =>{
  isShowGalery.value = true
  imageLighboxGalery.value = imagePath
}


const submitAvatar = async () => {
  inputAvatar.post(route("dashboard.profile.multimedia.avatar"), {
    onFinish() {
      inputAvatar.avatar = null;
    }
  });
  // Inertia.put(route('dashboard.profile.multimedia.avatar'), {
  //   avatar: inputAvatar.value.avatar,
  //   _method: 'put',
  // }, {  forceFormData: true })
};

const submitGallery = async () => {
  inputGallery.post(route("dashboard.profile.multimedia.gallery"),
  {
    onFinish () {
      inputGallery.images = [];
      files.value = []
      inputGallery.images = null;
      files.value = null;
    }
  });
  // Inertia.put(route('dashboard.profile.multimedia.avatar'), {
  //   avatar: inputAvatar.value.avatar,
  //   _method: 'put',
  // }, {  forceFormData: true })
};

const deleteGallery = async (id) => {
  Inertia.delete(
    route("dashboard.profile.multimedia.gallery.delete", { multimedia: id }),
    {
    }
  );
};

const deleteFileItem = (index) => {
  files.value = files.value.filter((item, elementIndex) => {
    return elementIndex !== index
  })
  inputGallery.images = files.value
}

const submitVideo = async () => {
  $externalResults.value = {};
  const validate = await v$.value.$validate();

  if (!validate) {
    return false;
  }

  mainVideo.put(route("dashboard.profile.multimedia.video"))
}
</script>

<template>
  <AdminLayout>
    <ProfileTabNav />
    <div class="md:max-w-[70%] mx-auto mb-5 pt-[16px]">
      <Fieldset legend="Logo">
        <div class="mb-5">
          <img
            :src="props.avatar ? props.avatar.path : placeholderPicture "
            class="max-w-[150px] md:max-w-[300px]"
            alt="Provider logo"
          >
        </div>

        <form @submit.prevent="submitAvatar">
          <AvatarPicker v-model="inputAvatar.avatar" />
          <Button :disabled="!inputAvatar.avatar" class="mt-5" :loading="inputAvatar.processing"
            >Update Logo</Button
          >
        </form>
      </Fieldset>

      <Fieldset legend="Gallery">
        <section class="pb-5" v-if="(props.gallery.length > 0)">
          <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <div
              v-for="image in props.gallery"
              class="relative"
            >
              <img
                :src="image.path" alt="image of galery profile"
                class="cursor-pointer h-full w-full object-cover shadow-lg hover:scale-110 transition-transform duration-300"
                @click="showInLightbox(image.path)"
              >
              <button
                class="bg-red-500 w-6 h-6 rounded-full absolute bottom-3 right-3"
                title="Delete this file"
                @click="deleteGallery(image.id)"
              >
                <DeleteFileIcon class="fill-white mx-auto" />
              </button>
            </div>
          </div>
          <LightboxGalery
            :image="imageLighboxGalery"
            :isShowGalery="isShowGalery"
            :closeImageLightbox="closeImageLightbox"
          />
        </section>

        <form @submit.prevent="submitGallery">
          <GaleryPicker v-model="inputGallery.images" :files="files" @deleteFileItem="deleteFileItem"/>
          <Button :disabled="!inputGallery.images" class="mt-5" :loading="inputGallery.processing"
            >Update gallery</Button
          >
        </form>
      </Fieldset>

      <Fieldset legend="Youtube video">
        <form @submit.prevent="submitVideo" class="mb-4 space-y-4">
          <Input
            label="Main video"
            v-model="mainVideo.video"
            :error-message="v$.video.$errors"
            :hasUrl="true"
          />
          <Button :loading="mainVideo.processing" :disabled="mainVideo.video===''">
            Update main video
          </Button>
        </form>
      </Fieldset>
    </div>
  </AdminLayout>
</template>
