import{_}from"./AppLayout-95c26e89.js";import{_ as u}from"./ThePaginator-16e396d2.js";import{_ as m}from"./SearchComponent-5ee2bbd0.js";import{C as p}from"./Carbon-053ffa43.js";import{T as h}from"./TableSection-0dcf2228.js";import{_ as f}from"./UserInformation-09fbcbd5.js";import{o,h as b,w as t,b as a,a as e,c as n,i as x,F as g,j as k,t as d,u as i,l as y,d as v}from"./app-3ea472c4.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./helpers-a978ac81.js";const C={class:"flex items-center gap-4"},N=e("th",null,"Cliente",-1),B=e("th",null,"Servicio",-1),E=e("th",null,"Estado",-1),V=e("th",null,"Acciones",-1),$={class:"hover:bg-gray-50"},F={class:"flex items-center gap-4"},S={class:"badge-danger"},T={key:0},j=e("td",{colspan:"7",class:"text-center"},"No data to display",-1),w=[j],J={__name:"Expired",props:{plans:{type:Object,required:!0}},setup(r){const c=[{name:"Inicio",route:"dashboard.index"},{name:"Planes expirados",route:"dashboard.plans.expired"}];return(l,D)=>(o(),b(_,{title:"Dashboard",breads:c},{default:t(()=>[a(h,null,{topbar:t(()=>[e("div",C,[a(m,{url:l.route("dashboard.plans.expired"),only:["plans"]},null,8,["url"])])]),header:t(()=>[N,B,E,V]),body:t(()=>[(o(!0),n(g,null,x(r.plans.data,(s,q)=>(o(),n("tr",$,[e("td",null,[e("div",F,[a(f,{user:{name:s.customer_name}},null,8,["user"])])]),e("td",null,d(s.service_name)+" ("+d(s.period)+" dias) ",1),e("td",null,[e("span",S," Expirado "+d(i(p).create(s.end_date).diffForHumans()),1)]),e("td",null,[a(i(y),{href:l.route("dashboard.customers.plans.create",s.customer_id),class:"badge-blue"},{default:t(()=>[v(" Renovar plan ")]),_:2},1032,["href"])])]))),256)),r.plans.data.length==0?(o(),n("tr",T,w)):k("",!0)]),paginator:t(()=>[a(u,{links:r.plans.links},null,8,["links"])]),_:1})]),_:1}))}};export{J as default};
