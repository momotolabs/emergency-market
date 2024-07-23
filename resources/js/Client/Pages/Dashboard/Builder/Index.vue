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
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="w-[250px] max-w-[250px]">
          <Button
            @click="newTemplate"
            :disabled="!user.provider_profile.signature"
            :title="!user.provider_profile.signature ? 'You should have to provide a signature on profile builder' : ''"
          >
            Create Template
          </Button>
          <span class="text-sm " v-if="!user.provider_profile.signature">You should have to provide a signature on profile builder</span>
        </div>
      </div>

      <div class="mt-10">
        <Table :header="headers" :items="props.contracts" @sortable="sort">
          <template #active="{item}">
            <Switch v-model="item.default" :value="item.default" @input="makeDefault(item)" :disabled="item.default" />
          </template>

          <template #actions="{item}">
            <!-- <Link href="/" class="text-primary">Show</Link> -->
            <a
              class="font-bold text-red-500 disabled:text-red-300 disabled:cursor-not-allowed text-2xl"
              :href="route('dashboard.builder.pdf', { contract: item.id })"
            >
              <FilePdfOutlined />
            </a>
            <Link
              :href="route('dashboard.builder.show', { contract: item.id })"
              class="font-bold text-primary text-2xl"
            >
              <EyeOutlined />
            </Link>
            <Link :href="route('dashboard.builder.edit', { contract: item.id })" class="font-bold text-green-600 text-2xl">
              <EditOutlined />
            </Link>
            <Link
              :href="route('dashboard.builder.delete', { contract: item.id })"
              as="button"
              method="DELETE"
              :disabled="item.default"
              class="font-bold text-red-500 disabled:text-red-300 disabled:cursor-not-allowed text-2xl"
            >
              <DeleteOutlined />
            </Link>
          </template>
        </Table>
      </div>
    </div>
  </AdminLayout>
</template>
