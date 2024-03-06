import{_ as b}from"./PrimaryButton-ee68edb4.js";import{_ as C}from"./AppLayout-69e75404.js";import{_ as N}from"./DialogModal-61530b51.js";import{_ as p}from"./InputForm-4cad8d49.js";import{_ as g}from"./SecondaryButton-79b2464c.js";import{j as v,T as S,o as i,f as $,w as s,b as o,d as c,t as _,u as r,c as f,k as I,F as w,h as E,a,i as P}from"./app-5a04f978.js";import{_ as B}from"./UserInformation-afc1de23.js";import{T}from"./TableSection-1cddbf40.js";import{t as x}from"./toast-0c928852.js";import{I as D}from"./IconCurrencyDollar-d7de0153.js";import{I as U}from"./IconPencil-59d73e07.js";import"./helpers-70796b54.js";import"./_plugin-vue_export-helper-c27b6911.js";const j=a("div",{class:"text-2xl font-extrabold text-gray-600"}," Personal ",-1),F=a("th",null,"ID",-1),H=a("th",null,"Nombre",-1),q=a("th",null,"Horario",-1),z=a("th",null,"Acciones",-1),A={class:"hover:bg-gray-50"},G={class:"flex gap-3"},L=["onClick"],M={key:0},O=a("td",{colspan:"4",class:"text-center"},"No data to display",-1),J=[O],ue={__name:"Index",props:{employees:{type:Object,required:!0}},setup(h){const u=v(!1),d=v(!0),V=[{name:"Inicio",route:"dashboard.index"},{name:"Personal",route:"dashboard.employees.index"}],e=S({id:null,name:"",phone:"",schedule:""});function y(n){e.id=n.id,e.name=n.name,e.phone=n.phone,e.schedule=n.schedule,d.value=!1,u.value=!0}function k(){d.value?e.post(route("dashboard.employees.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Empleado creado correctamente!"),m()}}):e.put(route("dashboard.employees.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Empleado actualizado correctamente!"),m()}})}function m(){e.reset(),e.clearErrors(),d.value=!0,u.value=!1}return(n,l)=>(i(),$(C,{title:"Personal",breads:V},{default:s(()=>[o(N,{show:u.value},{title:s(()=>[c(_(d.value?"Nuevo":"Editar"),1)]),content:s(()=>[o(p,{text:"Nombre",name:"name",modelValue:r(e).name,"onUpdate:modelValue":l[0]||(l[0]=t=>r(e).name=t)},null,8,["modelValue"]),o(p,{text:"Celular",name:"phone",modelValue:r(e).phone,"onUpdate:modelValue":l[1]||(l[1]=t=>r(e).phone=t),type:"number"},null,8,["modelValue"]),o(p,{text:"Horario",name:"schedule",modelValue:r(e).schedule,"onUpdate:modelValue":l[2]||(l[2]=t=>r(e).schedule=t)},null,8,["modelValue"])]),footer:s(()=>[o(g,{onClick:m},{default:s(()=>[c(" Cancelar ")]),_:1}),o(b,{type:"button",onClick:k},{default:s(()=>[c(" Guardar ")]),_:1})]),_:1},8,["show"]),o(T,null,{topbar:s(()=>[j,o(b,{type:"button",onClick:l[3]||(l[3]=t=>u.value=!0)},{default:s(()=>[c(" Nuevo ")]),_:1})]),header:s(()=>[F,H,q,z]),body:s(()=>[(i(!0),f(w,null,I(h.employees,(t,K)=>(i(),f("tr",A,[a("td",null,_(t.id),1),a("th",null,[o(B,{user:t},null,8,["user"])]),a("td",null,_(t.schedule),1),a("td",null,[a("div",G,[o(r(P),{href:n.route("dashboard.employees.show",t.id),tooltip:"Pagos"},{default:s(()=>[o(r(D))]),_:2},1032,["href"]),a("span",{role:"button",tooltip:"Editar",onClick:Q=>y(t)},[o(r(U))],8,L)])])]))),256)),h.employees.length==0?(i(),f("tr",M,J)):E("",!0)]),_:1})]),_:1}))}};export{ue as default};