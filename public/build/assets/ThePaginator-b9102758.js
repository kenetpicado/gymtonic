import{m,g as l,o as n,c as s,a as k,b as g,u as h,j as c,F as f,i as b,n as y,t as C,O as x}from"./app-fcae524f.js";import{c as _,f as w}from"./AppLayout-ed64ce15.js";var L=_("chevron-left","IconChevronLeft",[["path",{d:"M15 6l-6 6l6 6",key:"svg-0"}]]);const P={key:0,class:"w-full py-2 px-4 mb-4"},S={class:"flex justify-end items-center gap-2"},V=["onClick"],N={__name:"ThePaginator",props:{links:{type:Object,required:!1}},setup(i){const r=i,a=m({search:null}),u=l(()=>r.links[0].url),d=l(()=>r.links[r.links.length-1].url),v=l(()=>r.links.slice(1,r.links.length-1));function o(p){const e=new URLSearchParams(window.location.search).get("search");e?a.search=e:delete a.search,x.get(p,a,{preserveState:!0,preserveScroll:!0})}return(p,e)=>i.links&&v.value.length>1?(n(),s("div",P,[k("div",S,[u.value?(n(),s("span",{key:0,onClick:e[0]||(e[0]=t=>o(u.value)),class:"px-3 hover:bg-gray-100 rounded-md",role:"button"},[g(h(L))])):c("",!0),(n(!0),s(f,null,b(v.value,t=>(n(),s("span",{onClick:j=>o(t.url),class:y(["px-3 rounded-md",{"bg-indigo-600 text-white":t.active,"hover:bg-indigo-50":!t.active}]),role:"button"},C(t.label),11,V))),256)),d.value?(n(),s("button",{key:1,onClick:e[1]||(e[1]=t=>o(d.value)),class:"px-3 hover:bg-gray-100 rounded-md",type:"button"},[g(h(w))])):c("",!0)])])):c("",!0)}};export{N as _};
