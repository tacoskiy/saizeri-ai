import Image from "next/image";

export function Header(){
    return (
        <div className="flex items-center justify-start w-screen h-32 p-12">
            <Image
                src="/logo.svg"
                alt="Logo"
                width={154}
                height={31}
            />

        </div>
    )
}