<script setup>
import { TableHeadItem, TableBodyItem, Pagination } from ".";
import { NoDataIcon } from '@/Client/Components/Icons'
const props = defineProps({
  header: Array,
  items: Array,
});

const headerExample = [
  {
    title: 'Name',
    value: 'name',
    main: true,
    sortable: false
  },
  {
    title: 'Date',
    value: 'signed_at',
    main: false,
    sortable: true
  },
]
</script>

<template>
  <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500">
      <thead
        class="text-xs text-gray-700 uppercase bg-gray-50"
      >
        <tr>
          <TableHeadItem
            v-for="(item, index) in props.header"
            :key="item.title + index"
            :item="item"
            @sortable="$emit('sortable', item)"
          />
          <th scope="col" class="py-3 px-6">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="props.items == null">
          <td colspan="4" class="w-full text-center py-5">
            <NoDataIcon class="mx-auto"/>
            <p>No Data</p>
          </td>
        </tr>
        <tr
          v-else
          class="bg-white border-b  items-center"
          v-for="(item, index) in props.items.data"
        >
          <template v-for="(itemHeader, indexHeader) in props.header">
            <TableBodyItem :item="itemHeader.value.split('.').reduce((acc, part) => acc && acc[part], item)" :main="itemHeader.main">
              <slot :name="itemHeader.slot" v-bind="{item}">
              </slot>
            </TableBodyItem>
          </template>
          <td class="py-4 px-6 text-right flex space-x-4 items-center justify-end">
            <slot name="actions" v-bind="{item}">
              Edit
            </slot>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <Pagination v-if="props.items != null" :links="props.items.links" :from="props.items.from" :to="props.items.to" :total="props.items.total" />
</template>
