<script setup>
import { AdminLayout } from "@/Client/Layouts/";
import { Table } from "@/Client/Components/Admin/Table";
import { FilePdfOutlined, EditOutlined } from '@ant-design/icons-vue'
import { ContractTabNav } from '@/Client/Components/Shared'
import dayjs from 'dayjs';

const props = defineProps(["invoices"]);
const tabledHead = [
  {
    title: "Subject",
    value: "subject",
    slot: "subject",
    main: true,
  },
  {
    title: "First name",
    value: "insured_contract.insured.first_name",
    slot: "first",
  },
  {
    title: "Last name",
    value: "insured_contract.insured.last_name",
    slot: "last",
  },
  {
    title: "Email",
    value: "insured_contract.insured.email",
    slot: "email",
  },
  {
    title: 'Insurance company',
    value: 'insured_contract.insured.insurance_company',
    slot:'insuranceCompany'
  },
  {
    title: "Issued date",
    value: "created_at",
    slot: "date",
  },
];
</script>

<template>
  <AdminLayout>
    <div class="mb-4">
    <ContractTabNav />
      <div class="mt-10">
        <Table :header="tabledHead" :items="props.invoices">
          <template #date="{ item }">
            {{ dayjs(item.created_at).format("MM/DD/YYYY") }}
          </template>
          <template #actions="{ item }">
            <div class="flex flex-row justify-center items-center">
            <a
              class="font-bold text-red-500 disabled:text-red-300 disabled:cursor-not-allowed text-2xl "
              :href="route('dashboard.invoices.pdf', { invoice: item.id })"
            >
              <FilePdfOutlined />
            </a>
            <Link :href="route('dashboard.invoices.edit', {invoice: item.id})" class="text-blue-500 text-2xl"><EditOutlined /></Link>
            <Link :href="route('dashboard.invoices.show', {id: item.id})" title="View invoice">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="-4 -2 24 24" width="24" fill="currentColor" class="w-6 h-6"><path d="M3 0h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3zm0 2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zm2 13h2a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm6-12a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm-6 6h6a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm0-3h6a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2zm.5-6h2A1.5 1.5 0 0 1 9 4.5v2A1.5 1.5 0 0 1 7.5 8h-2A1.5 1.5 0 0 1 4 6.5v-2A1.5 1.5 0 0 1 5.5 3z"></path></svg>
            </Link>
            </div>
          </template>
        </Table>
      </div>
    </div>
  </AdminLayout>
</template>
