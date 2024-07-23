<script setup>
import { AdminLayout } from '@/Client/Layouts'
import { ContractContent } from '@/Client/Components/Shared/Contract'

const props = defineProps(['contract'])
</script>
<template>
  <AdminLayout>
    <h2 class="font-semibold text-xl">{{ props.contract.name }}</h2>
    <ContractContent :content="props.contract?.content" />
  </AdminLayout>
</template>