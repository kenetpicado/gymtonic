import{o as i,c as n,a as s,r as t,g as r,B as l,b as m,w as d,e as _,j as p}from"./app-fcae524f.js";import{_ as u}from"./_plugin-vue_export-helper-c27b6911.js";const f={},h={class:"md:col-span-1 flex justify-between"},$={class:"px-4 sm:px-0"},g={class:"text-lg font-medium text-gray-900"},x={class:"mt-1 text-sm text-gray-600"},v={class:"px-4 sm:px-0"};function b(o,c){return i(),n("div",h,[s("div",$,[s("h3",g,[t(o.$slots,"title")]),s("p",x,[t(o.$slots,"description")])]),s("div",v,[t(o.$slots,"aside")])])}const y=u(f,[["render",b]]),w={class:"grid grid-cols-3 md:gap-6"},S={class:"col-span-4 space-y-3 text-lg"},B={class:"mt-0 col-span-2"},j={class:"p-4 bg-white sm:p-6"},k={class:"flex flex-col gap-6"},N={key:0,class:"flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md gap-4"},E={__name:"FormSection",emits:["submitted"],setup(o){const c=r(()=>!!l().actions);return(e,a)=>(i(),n("div",w,[m(y,null,{title:d(()=>[t(e.$slots,"title")]),description:d(()=>[s("div",S,[t(e.$slots,"description")])]),_:3}),s("div",B,[s("form",{onSubmit:a[0]||(a[0]=_(V=>e.$emit("submitted"),["prevent"]))},[s("div",j,[s("div",k,[t(e.$slots,"form")])]),c.value?(i(),n("div",N,[t(e.$slots,"actions")])):p("",!0)],32)])]))}};export{E as _};