<script setup>
import { AdminLayout } from '@/Client/Layouts'
import { Button, Switch } from '@/Client/Components/Form'
import { Table } from '@/Client/Components/Admin/Table';
import { Inertia } from '@inertiajs/inertia';
import { EditOutlined, DeleteOutlined, FilePdfOutlined, EyeOutlined } from '@ant-design/icons-vue'
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from 'vue';

const user = computed(() => usePage().props.value.auth?.user);


const props = defineProps(['contracts'])

const newTemplate = () => {
  Inertia.visit(route('dashboard.builder.create'));
}
const headers = [
  {
    title: 'Name',
    value: 'name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Active',
    value: 'default',
    slot: 'active',
    sortable: true
  },
];

const sort = (item) => {
  console.log(item);
}

const makeDefault = (item) => {
  Inertia.put(route('dashboard.builder.default', {contract: item.id}))
}


</script>

<template>
  <AdminLayout>
    <div class="mb-4">
      <div class="mt-10">
        <button class="bg-success rounded-sm ml-3" v-on:click="confirmation"> Download Contract </button>
      </div>
    </div>
  </AdminLayout>
</template>
<script>
       
  export default {
    methods: {
        confirmation(){
            this.$swal({
              html: 'This document is a sample contract which may be used as a guide by parties performing emergency tree removal.<br>This document is not intended to be and is not legal advice.  This document does not address differences in laws regarding contractors, service providers, billing, collections, interest rate, waivers and other state-specific or federally regulated matters.<br>YOU SHOULD CONSULT AN ATTORNEY BEFORE USING ANY DOCUMENT.',
              input: 'checkbox',
              inputValue: 0,
              inputPlaceholder:
                'I agree',
              showCancelButton: true,
              inputValidator: (result) => {
                return !result && 'You need to agree'
              }
            }).then((result) => {
              if (result.value) {
                var url = window.location.protocol + "//" + window.location.host;
                var link = document.createElement("a");
                link.setAttribute('download', '');
                link.href = url + '/dashboard/extras/samplecontract';
                document.body.appendChild(link);
                link.click();
                link.remove();
              }
            });
        },
    }
  }
</script>