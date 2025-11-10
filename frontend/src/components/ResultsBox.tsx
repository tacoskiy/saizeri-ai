import Image from "next/image";

export function ResultsBox() {
    return (
        <div className="flex justify-start w-[452px] h-45 bg-linear-to-r from-[#ffffff33] to-[#3435411A] border-2 border-green rounded-3xl p-4 gap-4">
            <Image
                src="/menuImg.png"
                alt="menu"
                width={180}
                height={150}
                className="rounded-3xl"
            />
            <div className="flex flex-col gap-5">
                <p className="flex items-center justify-center w-18 h-12 text-white text-2xl font-bold  bg-[#7E5C4E]">2101</p>
                <p className="text-2xl font-bold">ミラノ風ドリア</p>
                <p className="text-2xl font-bold">273円(税込300円)</p>
            </div>
        </div>
    )
}