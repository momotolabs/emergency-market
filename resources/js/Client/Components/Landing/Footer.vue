<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { Nav } from '@/Client/Components/Landing/Pieces'
import { IconFacebook, IconYoutube } from '@/Client/Components/Landing/Icons'

const footerNavItems = ref([
  { anchor: '#benefits', anchorTitle: 'Benefits' },
  { anchor: '#services', anchorTitle: 'Services' },
  { anchor: '#about-us', anchorTitle: 'About Us' },
  { anchor: '#our-purpose', anchorTitle: 'Our Purpose' },
  { anchor: '#reviews', anchorTitle: 'Reviews' },
])
</script>

<template>
  <footer class="site-footer">
    <div class="footer-nav">
      <div>
        <Nav :navItems="footerNavItems" />

        <Link href="/" class="home-link">
          <img src="@/Client/assets/images/emergency-logo-beta.svg" class="site-logo" alt="emergency's Logo" />
        </Link>
      </div>
      <div class="footer-nav__right">
        <Link href="/join">Join</Link>
        <Link :href="'/login'">{{ 'Login' }}</Link>
      </div>
    </div>

    <hr>

    <div class="footer-social-network">
      <div class="social__icons">
        <a href="https://www.facebook.com/emergencyMarket" target="_blanc">
          <IconFacebook />
        </a>
        <a href="https://www.youtube.com/channel/UCR1an4FFEd8MLSmwhaidirg" target="_blanc">
          <IconYoutube />
        </a>
      </div>
    </div>
    <div class="copyright">
      <div>
        <Link href="/terms-of-services">
          Terms of services
        </Link>
        <Link href="/privacy-policy">
          Privacy Policy
        </Link>
      </div>
      <div>© emergency Market!</div>
    </div>
  </footer>
</template>

<style lang="css" scoped>
.site-footer {
  background-color: #fff;
  padding: 100px 0px;
}

.footer-nav {
  display: flex;
  justify-content: space-between;
}

.footer-nav div {
  display: inherit;
  flex-direction: column;
}

.footer-nav__right {
  padding-right: 55px;
  justify-content: center;
}

.footer-nav__right a {
  text-align: right;
  color: #000;
  font-weight: 500;
  font-size: 15px;
  line-height: 18px;
  margin-bottom: 15px;
}

@media (min-width: 1024px) {
  .footer-nav__right a:last-child {
    margin-left: 40px;
  }
}

.home-link {
  order: -1;
}

@media (min-width: 1024px) {
  .footer-nav__right {
    padding-right: 0px;
  }

  .footer-nav div {
    flex-direction: row;
    flex-wrap: nowrap;
  }

  .home-link {
    order: 1;
  }
}

.site-logo {
  height: 30px;
  padding-left: 55px;
}

hr {
  background: rgba(0, 0, 0, 0.5);
  margin: 40px 25px;
}

@media (min-width: 1024px) {
  .footer-nav {
    width: 85%;
    margin: auto;
  }

  hr {
    margin: 40px 80px 60px;
  }
}

.site-footer .footer-social-network {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.social__icons {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  column-gap: 15px;
  margin-bottom: 25px;
}

.copyright {
  display: flex;
  width: 85%;
  margin: auto;
  font-weight: 400;
  font-size: 15px;
  line-height: 24px;
}

.copyright>div {
  width: 45%;
}

.copyright a {
  color: #000000d9;
  margin-right: 20px
}
</style>
