"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[303],{8588:(e,n,s)=>{s.r(n),s.d(n,{FacebookLoginWeb:()=>t});var o=s(9895);class t extends o.Uw{constructor(){super({name:"FacebookLogin",platforms:["web"]})}initialize(e){const n={version:"v10.0"};return new Promise(((s,o)=>{try{return this.loadScript(e.locale).then((()=>{FB.init(Object.assign(Object.assign({},n),e)),s()}))}catch(e){o(e)}}))}loadScript(e){if("undefined"==typeof document)return Promise.resolve();if(null===document||void 0===document?void 0:document.getElementById("fb"))return Promise.resolve();const n=document.getElementsByTagName("head")[0],s=document.createElement("script");return new Promise((o=>{s.defer=!0,s.async=!0,s.id="fb",s.onload=()=>{o()},s.src=`https://connect.facebook.net/${null!=e?e:"en_US"}/sdk.js`,n.appendChild(s)}))}async login(e){return console.log("FacebookLoginWeb.login",e),new Promise(((n,s)=>{FB.login((e=>{console.debug("FB.login",e),"connected"===e.status?n({accessToken:{token:e.authResponse.accessToken}}):s({accessToken:{token:null}})}),{scope:e.permissions.join(",")})}))}async logout(){return new Promise((e=>{FB.logout((()=>e()))}))}async getCurrentAccessToken(){return new Promise(((e,n)=>{FB.getLoginStatus((s=>{if("connected"===s.status){const n={accessToken:{applicationId:void 0,declinedPermissions:[],expires:void 0,isExpired:void 0,lastRefresh:void 0,permissions:[],token:s.authResponse.accessToken,userId:s.authResponse.userID}};e(n)}else n({accessToken:{token:null}})}))}))}async getProfile(e){const n=e.fields.join(",");return new Promise(((e,s)=>{FB.api("/me",{fields:n},(n=>{n.error?s(n.error.message):e(n)}))}))}}}}]);