<script setup>
import { AdminLayout } from '@/Client/Layouts/'
import { ContractTabNav } from '@/Client/Components/Shared'
import { Table } from '@/Client/Components/Admin/Table'
import { EyeOutlined, } from '@ant-design/icons-vue'
const props = defineProps(['contracts'])
const tabledHead = [
  {
    title: 'first Name',
    value: 'insured.first_name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Last Name',
    value: 'insured.last_name',
    slot: 'name',
    main: true,
  },
  {
    title: 'Date Viewed',
    value: 'created_at',
    slot: 'created_at',
    sortable: false
  },
  {
    title: 'Insurance company',
    value: 'insured.insurance_company',
    slot: 'insurance',
    sortable: false
  },
  {
    title: 'Homeowner email',
    value: 'insured.email',
    slot: 'homeowner',
    sortable: false
  },
]
</script>
<template>
  <AdminLayout>
    <div class="mb-4">
      <ContractTabNav />

      <div class="mb-5">
        <Table :header="tabledHead" :items="props.contracts">


          <template #actions="{item}">
            <div class="flex items-center">

              <Link
                :href="route('dashboard.contracts.show', { insuredcontract: item.id })"
                class="text-blue-700 text-xl"
              >
                <EyeOutlined />
              </Link>
            </div>
          </template>
        </Table>
      </div>
    </div>
  </AdminLayout>
</template>
