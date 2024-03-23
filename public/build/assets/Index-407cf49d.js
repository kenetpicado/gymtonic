import{_ as b}from"./PrimaryButton-1a2d1e4a.js";import{_ as N}from"./AppLayout-35c1889e.js";import{_ as g}from"./DialogModal-7521c975.js";import{_ as p}from"./InputForm-943a80c4.js";import{_ as S}from"./SecondaryButton-ed9273fc.js";import{j as v,T as $,o as i,f as I,w as s,b as t,d as c,t as _,u as r,c as f,k as w,F as E,h as P,a as o,i as B}from"./app-9474134e.js";import{_ as T}from"./UserInformation-4d5d6053.js";import{T as D}from"./TableSection-1b255b47.js";import{t as x}from"./toast-532d1d63.js";import{I as U}from"./IconCurrencyDollar-03f87674.js";import{I as j}from"./IconPencil-311f765e.js";import"./_plugin-vue_export-helper-c27b6911.js";const F=o("div",{class:"text-2xl font-extrabold text-gray-600"}," Personal ",-1),H=o("th",null,"ID",-1),q=o("th",null,"Nombre",-1),z=o("th",null,"Horario",-1),A=o("th",null,"Acciones",-1),G={class:"hover:bg-gray-50"},L={class:"flex gap-3"},M=["onClick"],O={key:0},J=o("td",{colspan:"4",class:"text-center"},"No data to display",-1),K=[J],ne={__name:"Index",props:{employees:{type:Object,required:!0}},setup(h){const u=v(!1),d=v(!0),V=[{name:"Inicio",route:"dashboard.index"},{name:"Personal",route:"dashboard.employees.index"}],e=$({id:null,name:"",phone:"",schedule:""});function y(n){e.id=n.id,e.name=n.name,e.phone=n.phone,e.schedule=n.schedule,d.value=!1,u.value=!0}function k(){d.value?e.post(route("dashboard.employees.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Empleado creado correctamente!"),m()}}):e.put(route("dashboard.employees.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Empleado actualizado correctamente!"),m()}})}function m(){e.reset(),e.clearErrors(),d.value=!0,u.value=!1}return(n,l)=>(i(),I(N,{title:"Personal",breads:V},{default:s(()=>[t(g,{show:u.value},{title:s(()=>[c(_(d.value?"Nuevo":"Editar"),1)]),content:s(()=>[t(p,{text:"Nombre",name:"name",modelValue:r(e).name,"onUpdate:modelValue":l[0]||(l[0]=a=>r(e).name=a)},null,8,["modelValue"]),t(p,{text:"Celular",name:"phone",modelValue:r(e).phone,"onUpdate:modelValue":l[1]||(l[1]=a=>r(e).phone=a),type:"number"},null,8,["modelValue"]),t(p,{text:"Horario",name:"schedule",modelValue:r(e).schedule,"onUpdate:modelValue":l[2]||(l[2]=a=>r(e).schedule=a)},null,8,["modelValue"])]),footer:s(()=>[t(S,{onClick:m},{default:s(()=>[c(" Cancelar ")]),_:1}),t(b,{type:"button",onClick:k},{default:s(()=>[c(" Guardar ")]),_:1})]),_:1},8,["show"]),t(D,null,{topbar:s(()=>[F,t(b,{type:"button",onClick:l[3]||(l[3]=a=>u.value=!0)},{default:s(()=>[c(" Nuevo ")]),_:1})]),header:s(()=>[H,q,z,A]),body:s(()=>[(i(!0),f(E,null,w(h.employees,(a,C)=>(i(),f("tr",G,[o("td",null,_(C+1),1),o("th",null,[t(T,{user:a},null,8,["user"])]),o("td",null,_(a.schedule),1),o("td",null,[o("div",L,[t(r(B),{href:n.route("dashboard.employees.show",a.id),tooltip:"Pagos"},{default:s(()=>[t(r(U))]),_:2},1032,["href"]),o("span",{role:"button",tooltip:"Editar",onClick:Q=>y(a)},[t(r(j))],8,M)])])]))),256)),h.employees.length==0?(i(),f("tr",O,K)):P("",!0)]),_:1})]),_:1}))}};export{ne as default};
