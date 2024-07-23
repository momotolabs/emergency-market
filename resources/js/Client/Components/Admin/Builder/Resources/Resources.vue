<template>
  <table class="resources-table">
    <tbody>
      <AdminBuilderResourcesItem
        v-for="(item, index) in resources"
        :indice="index"
        :item="item"
        @remove="remove(index)"
        @update="update"
      />
    </tbody>
  </table>
  <div>
    <form @submit.prevent="addItem">
      <select id="" v-model="resource" name="" required>
        <option v-for="(item, index) in allResources" :value="item">
          {{ item.resource_name }}
        </option>
      </select>
      <button type="submit">
        Add
      </button>
    </form>
  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue'

const request = useRequest()
const { data } = await request.get('/providers/company/asset_prices')

const allResources = data.value.data

const props = defineProps(['items'])
const emit = defineEmits(['input'])
const resources = ref([])

const increment = ref(0)
const resource = ref(null)

const addItem = () => {
  resources.value.push({
    key: increment.value,
    units: 0,
    price_cents: 0,
    price_currency: 'USD',
    pricing_resource_id: resource.value.id,
    resource: resource.value
  })
  increment.value++
}

const update = ({ item, index }) => {
  resources.value[index] = item
}

const remove = (index) => {
  resources.value.splice(index, 1)
}

// watch(resources, () => {
//   emit("input", resources.value);
// }, {deep: true});
</script>

<style scoped lang="scss">
.resources-table {
  width: 100%;
  border-collapse: collapse;

  tr:not(:last-child) {
    border-bottom: 0.5px solid #c0c0c0;
  }

  tr {
    td {
      padding: 0.8rem 0;
    }
  }
}
</style>
