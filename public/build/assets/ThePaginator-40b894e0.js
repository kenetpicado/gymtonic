import{m as k,g as c,o as n,c as s,a as f,b as h,u as m,j as u,F as y,i as b,n as C,t as x,O as _}from"./app-93ea45e5.js";import{c as w,f as L}from"./AppLayout-46e562f0.js";var P=w("chevron-left","IconChevronLeft",[["path",{d:"M15 6l-6 6l6 6",key:"svg-0"}]]);const V={key:0,class:"w-full py-2 px-4 mb-4"},S={class:"flex justify-end items-center gap-2"},j=["onClick"],N={__name:"ThePaginator",props:{links:{type:Object,required:!1}},setup(i){const r=i,a=k({search:null}),p=c(()=>r.links[0].url),d=c(()=>r.links[r.links.length-1].url),v=c(()=>r.links.slice(1,r.links.length-1));function o(g){const t=new URLSearchParams(window.location.search);["search","from","to","type"].forEach(e=>{const l=t.get(e);l!==null?a[e]=l:delete a[e]}),_.get(g,a,{preserveState:!0,preserveScroll:!0})}return(g,t)=>i.links&&v.value.length>1?(n(),s("div",V,[f("div",S,[p.value?(n(),s("span",{key:0,onClick:t[0]||(t[0]=e=>o(p.value)),class:"px-3 hover:bg-gray-100 rounded-md",role:"button"},[h(m(P))])):u("",!0),(n(!0),s(y,null,b(v.value,e=>(n(),s("span",{onClick:l=>o(e.url),class:C(["px-3 rounded-md",{"bg-indigo-600 text-white":e.active,"hover:bg-indigo-50":!e.active}]),role:"button"},x(e.label),11,j))),256)),d.value?(n(),s("button",{key:1,onClick:t[1]||(t[1]=e=>o(d.value)),class:"px-3 hover:bg-gray-100 rounded-md",type:"button"},[h(m(L))])):u("",!0)])])):u("",!0)}};export{N as _};
