import{f as b,T as D,o as r,h as v,w as a,b as n,d as u,t as m,a as s,s as j,v as F,u as l,c as f,j as g,i as M,F as z,K as B}from"./app-3ea472c4.js";import{C as T}from"./Carbon-053ffa43.js";import{_ as A}from"./DialogModal-b98b38c2.js";import{_ as C}from"./PrimaryButton-cbad163b.js";import{_ as E}from"./SecondaryButton-369c6abe.js";import{c as y,_ as q}from"./AppLayout-95c26e89.js";import{t as h}from"./toast-523d5346.js";import{c as G}from"./alert-8ef5c8b5.js";import{I as K}from"./IconTrash-be9d1b56.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./sweetalert2.all-435f180d.js";var L=y("circle-check-filled","IconCircleCheckFilled",[["path",{d:"M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z","stroke-width":"0",fill:"currentColor",key:"svg-0"}]]),O=y("circle-check","IconCircleCheck",[["path",{d:"M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0",key:"svg-0"}],["path",{d:"M9 12l2 2l4 -4",key:"svg-1"}]]);const U={class:"flex flex-col gap-6"},Y={key:0,class:"text-sm text-red-600 mt-1"},H={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 py-4"},J={class:"flex items-center justify-between mb-6 gap-4"},P=s("div",{class:"text-2xl font-extrabold text-gray-600 col-span-2"},"Notas",-1),Q={class:"grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6"},R={key:0,class:"text-gray-400"},W={class:"w-full p-6 bg-white shadow-soft-xl rounded-xl"},X={class:"flex flex-col justify-between h-full"},Z={class:"flex justify-between"},ee={class:"mb-2 lowercase text-gray-400"},te=["onClick"],pe={__name:"Index",props:{notes:{type:Object,required:!0}},setup(k){const c=b(!1),i=b(!0),e=D({id:null,is_done:!1,text:""}),w=[{name:"Inicio",route:"dashboard.index"},{name:"Notas",route:"dashboard.notes.index"}];function N(t){e.id=t.id,e.text=t.text,i.value=!1,c.value=!0}function $(t){e.id=t.id,e.text=t.text,e.is_done=!0,p()}function S(t){e.id=t.id,e.text=t.text,e.is_done=!1,p()}function I(t){G(()=>{e.delete(route("dashboard.notes.destroy",t),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota eliminada correctamente!")}})},"¿Estás seguro de eliminar esta nota?")}function V(){i.value?e.post(route("dashboard.notes.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota creada correctamente!"),x()}}):p()}function p(){e.put(route("dashboard.notes.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota actualizada correctamente!"),x()}})}function x(){e.reset(),i.value=!0,c.value=!1,B().props.errors={}}return(t,d)=>(r(),v(q,{title:"Dashboard",breads:w},{default:a(()=>[n(A,{show:c.value},{title:a(()=>[u(m(i.value?"Nuevo":"Editar"),1)]),content:a(()=>[s("div",U,[s("div",null,[j(s("textarea",{rows:"4",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full","onUpdate:modelValue":d[0]||(d[0]=o=>l(e).text=o)},null,512),[[F,l(e).text]]),t.$page.props.errors.text?(r(),f("p",Y,m(t.$page.props.errors.text),1)):g("",!0)])])]),footer:a(()=>[n(E,{onClick:x},{default:a(()=>[u(" Cancelar ")]),_:1}),n(C,{type:"button",onClick:V},{default:a(()=>[u(" Guardar ")]),_:1})]),_:1},8,["show"]),s("div",H,[s("div",J,[P,n(C,{type:"button",onClick:d[1]||(d[1]=o=>c.value=!0)},{default:a(()=>[u(" Nuevo ")]),_:1})]),s("div",Q,[k.notes.length==0?(r(),f("div",R," No hay notas ")):g("",!0),(r(!0),f(z,null,M(k.notes,(o,se)=>(r(),f("div",W,[s("div",X,[s("div",null,[s("div",Z,[s("div",ee,m(l(T).create(o.created_at).format("d de F, Y")),1),o.is_done?(r(),v(l(L),{key:1,class:"text-green-500",role:"button",onClick:_=>S(o)},null,8,["onClick"])):(r(),v(l(O),{key:0,onClick:_=>$(o),role:"button"},null,8,["onClick"]))]),s("p",{class:"mb-4 font-normal text-gray-600 mt-2",role:"button",onClick:_=>N(o)},m(o.text),9,te)]),n(l(K),{onClick:_=>I(o.id),role:"button",size:"20",class:"text-gray-400"},null,8,["onClick"])])]))),256))])])]),_:1}))}};export{pe as default};
