<script setup>
import { Card, CardHeader } from '@/Client/Components/Shared';
import { Button } from '@/Client/Components/Form';
import { Inertia } from '@inertiajs/inertia';

const next = () => {
  Inertia.visit(route('provider.first-time'));
}
</script>

<template>
  <Default>
    <Card class="mt-28">
      <template #header>
        <CardHeader title="Welcome">
          <template #subtitle>
            Now that we've gotten the basics out of the way, within the next few
            screens were going to ask about your business to get you into the
            system and fully registered.
            <br />
            <br />
            emergency Market is very thorough in our display of what the true
            market is. Then please take your time to answer all questions so
            that we can get you registered and displayed on the marketplace.
            <br />
            <br />
          </template>
        </CardHeader>
      </template>

      <div class="mt-12">
        <Button class="flex justify-center items-center" type="button" @click="next">
          Next
          <svg
            class="ml-8 h-[14px]"
            xmlns="http://www.w3.org/2000/svg"
            width="9"
            height="16"
            viewBox="0 0 9 16"
            fill="none"
          >
            <path
              d="M1 1L7.96317 7.96317L1 14.9263"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </Button>
      </div>
    </Card>
  </Default>
</template>
