<script setup>
import { ref } from "vue";
import { Label } from ".";

const props = defineProps(['label', 'placeholder', 'lat', 'lng', 'direction', 'required']);
const emit = defineEmits(['update:lat', 'update:lng', 'update:direction'])
const autocomplete = ref(null);

const center = ref({
  lat: props.lat ? props.lat : 40.689247,
  lng: props.lng ? props.lng : -74.044502,
  direction: props.direction ?? "",
});

const setPlace = (param) => {
  center.value.direction = param.formatted_address;
  center.value.lat = param.geometry.location.lat();
  center.value.lng = param.geometry.location.lng();
  emit('update:lat', center.value.lat);
  emit('update:lng', center.value.lng);
  emit('update:direction', center.value.direction);
};

const markerChange = (param) => {
  center.value.lat = param.latLng.lat();
  center.value.lng = param.latLng.lng();
  emit('update:lat', center.value.lat);
  emit('update:lng', center.value.lng);
};
</script>

<template>
  <Label :label="props.label">
    <GMapAutocomplete
      :placeholder="props.placeholder"
      @place_changed="setPlace"
      @change="emit('update:direction', $event.target.value)"
      :componentRestrictions="{
        country: ['us']
      }"
      ref="autocomplete"
      :value="center.direction"
      class="bg-input-background border-none p-[18px] text-[16px] rounded-lg active:outline-none hover:outline-none focus:outline-none disabled:bg-gray-300 placeholder:text-placeholder placeholder:font-medium"
      :required="props.required"
    >
    </GMapAutocomplete>
  </Label>
  <GMapMap style="width: 100%; height: 500px" :center="center" :zoom="10">
    <GMapMarker
      :position="center"
      draggable
      @dragend="markerChange"
    ></GMapMarker>
  </GMapMap>
</template>
