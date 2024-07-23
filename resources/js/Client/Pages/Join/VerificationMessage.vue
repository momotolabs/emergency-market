<script setup>
import { Default as DefaultLayout } from "@/Client/Layouts";
import { Card, CardHeader, CardAlert } from "@/Client/Components/Shared";
</script>

<template>
  <DefaultLayout>
    <CardAlert>
      <div class="bg-[#fff] md:w-[50%] lg:w-[30%] mx-auto p-5 shadow-md mt-32 rounded-md">
        Welcome to emergency, we have sent you an email to continue with your
        registration
      </div>
    </CardAlert>
  </DefaultLayout>
</template>
