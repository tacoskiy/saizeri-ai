import Image from "next/image";

type MenuProps = {
    name: string
    price: string
    image: string
}
// 仮で入れてます
const Menu =[
    {
    image:"/menuImg.png",
    name:"ミラノ風ドリア",
    price:"273円(税込300円)",
    pass:"2101"
    },
    {
    image: "/menuImg.png",
    name: "海老グラタン",
    price: "320円(税込352円)",
    pass: "2102",
  },
  {
    image: "/menuImg.png",
    name: "チーズリゾット",
    price: "280円(税込308円)",
    pass: "2103",
  },
]

export function ResultsBox() {
    return (
        <div className="flex flex-col items-center justify-center gap-4">
            <p className="text-3xl font-bold text-green">AIからの提案</p>
            {Menu.map((Menu, index) => (
                <div key={index} className="flex justify-start w-[452px] h-45 bg-linear-to-r from-[#ffffff33] to-[#3435411A] border-2 border-green rounded-3xl p-4 gap-4">
                    <Image
                        src={Menu.image}
                        alt={Menu.name}
                        width={180}
                        height={150}
                        className="rounded-3xl"
                    />
                    <div className="flex flex-col gap-5">
                        <p className="flex items-center justify-center w-18 h-12 text-white text-2xl font-bold  bg-[#7E5C4E]">
                            {Menu.pass
                        }</p>
                        <p className="text-2xl font-bold">{Menu.name}</p>
                        <p className="text-2xl font-bold">{Menu.price}</p>
                    </div>
                </div>
            ))}
        </div>
    )
}